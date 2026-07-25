<?php

namespace App\Support;

/**
 * Lightweight HTML sanitizer for rich episode content.
 * Keeps common formatting tags while stripping scripts/event handlers.
 */
class HtmlSanitizer
{
    /**
     * Tags allowed in educational episode content (CKEditor/TinyMCE style).
     *
     * @var list<string>
     */
    private const ALLOWED_TAGS = [
        'p', 'br', 'hr', 'div', 'span', 'section',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup',
        'ul', 'ol', 'li',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'a', 'img', 'figure', 'figcaption',
        'blockquote', 'pre', 'code',
        'iframe', 'video', 'source', 'audio',
    ];

    /**
     * Allowed attributes per tag (global safe attrs applied where noted).
     *
     * @var array<string, list<string>>
     */
    private const ALLOWED_ATTRS = [
        '*' => ['class', 'id', 'style', 'title'],
        'a' => ['href', 'target', 'rel', 'name'],
        'img' => ['src', 'alt', 'width', 'height', 'loading'],
        'iframe' => ['src', 'width', 'height', 'allow', 'allowfullscreen', 'frameborder'],
        'video' => ['src', 'controls', 'width', 'height', 'poster'],
        'audio' => ['src', 'controls'],
        'source' => ['src', 'type'],
        'td' => ['colspan', 'rowspan'],
        'th' => ['colspan', 'rowspan'],
        'table' => ['border', 'cellpadding', 'cellspacing'],
    ];

    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        // Normalize upload relative paths before sanitizing.
        $html = str_replace('src="upload/', 'src="/upload/', $html);
        $html = str_replace("src='upload/", "src='/upload/", $html);

        $previous = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $wrapped = '<?xml encoding="UTF-8"><div id="__sanitize_root__">'.$html.'</div>';
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $root = $dom->getElementById('__sanitize_root__');
        if (! $root) {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);

            return e(strip_tags($html));
        }

        self::walk($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $dom->saveHTML($child);
        }

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return $clean;
    }

    private static function walk(\DOMNode $node): void
    {
        if (! $node->hasChildNodes()) {
            return;
        }

        /** @var list<\DOMNode> $children */
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                /** @var \DOMElement $child */
                $tag = strtolower($child->tagName);

                if (in_array($tag, ['script', 'style', 'object', 'embed', 'link', 'meta', 'base', 'form', 'input', 'button', 'textarea', 'select'], true)) {
                    $child->parentNode?->removeChild($child);
                    continue;
                }

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    // Unwrap unknown tags but keep children text/content.
                    while ($child->firstChild) {
                        $child->parentNode?->insertBefore($child->firstChild, $child);
                    }
                    $child->parentNode?->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child, $tag);
                self::walk($child);
            } elseif ($child->nodeType === XML_COMMENT_NODE) {
                $child->parentNode?->removeChild($child);
            }
        }
    }

    private static function sanitizeAttributes(\DOMElement $el, string $tag): void
    {
        if (! $el->hasAttributes()) {
            return;
        }

        $allowed = array_unique(array_merge(
            self::ALLOWED_ATTRS['*'] ?? [],
            self::ALLOWED_ATTRS[$tag] ?? []
        ));

        /** @var list<string> $toRemove */
        $toRemove = [];

        foreach (iterator_to_array($el->attributes) as $attr) {
            $name = strtolower($attr->name);
            $value = trim($attr->value);

            if (str_starts_with($name, 'on')) {
                $toRemove[] = $attr->name;
                continue;
            }

            if (! in_array($name, $allowed, true)) {
                $toRemove[] = $attr->name;
                continue;
            }

            if (in_array($name, ['href', 'src'], true)) {
                if (! self::isSafeUrl($value)) {
                    $toRemove[] = $attr->name;
                    continue;
                }
            }

            if ($name === 'style' && self::hasDangerousCss($value)) {
                $toRemove[] = $attr->name;
                continue;
            }

            if ($name === 'target' && $value === '_blank') {
                $el->setAttribute('rel', 'noopener noreferrer');
            }
        }

        foreach ($toRemove as $name) {
            $el->removeAttribute($name);
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, '/')) {
            return true;
        }

        if (str_starts_with($url, '//')) {
            return false;
        }

        $lower = strtolower($url);
        if (preg_match('/^\s*(javascript|vbscript|data)\s*:/i', $lower)) {
            // Allow only data:image/*
            if (preg_match('/^\s*data:image\/(png|jpe?g|gif|webp|svg\+xml)\s*;/i', $lower)) {
                return true;
            }

            return false;
        }

        if (preg_match('#^(https?:|mailto:|/upload/)#i', $url)) {
            return true;
        }

        // Relative path without scheme.
        return ! preg_match('#^[a-z][a-z0-9+.-]*:#i', $url);
    }

    private static function hasDangerousCss(string $css): bool
    {
        return (bool) preg_match('/expression\s*\(|javascript\s*:|url\s*\(\s*[\'"]?\s*javascript/i', $css);
    }
}

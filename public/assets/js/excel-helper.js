/**
 * Excel helper (client-side only) using SheetJS
 * - Export table / JSON to .xlsx
 * - Parse uploaded .xlsx/.xls/.csv for quiz questions
 */
window.ExcelHelper = (function () {
    function ensureXLSX() {
        if (typeof XLSX === 'undefined') {
            alert('Library Excel belum dimuat. Periksa koneksi internet.');
            return false;
        }
        return true;
    }

    function downloadWorkbook(wb, filename) {
        XLSX.writeFile(wb, filename);
    }

    function exportTable(tableId, filename) {
        if (!ensureXLSX()) return;
        var table = document.getElementById(tableId);
        if (!table) {
            alert('Tabel tidak ditemukan.');
            return;
        }
        var wb = XLSX.utils.table_to_book(table, { sheet: 'Data' });
        downloadWorkbook(wb, filename || 'export.xlsx');
    }

    function exportJson(rows, sheetName, filename) {
        if (!ensureXLSX()) return;
        var ws = XLSX.utils.json_to_sheet(rows);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName || 'Data');
        downloadWorkbook(wb, filename || 'export.xlsx');
    }

    function downloadTemplateSoal(filename) {
        if (!ensureXLSX()) return;
        var rows = [
            {
                pertanyaan: 'Contoh: Ibu kota Indonesia adalah?',
                opsi_a: 'Jakarta',
                opsi_b: 'Bandung',
                opsi_c: 'Surabaya',
                opsi_d: 'Medan',
                opsi_e: 'Makassar',
                jawaban: 'a'
            }
        ];
        exportJson(rows, 'Template Soal', filename || 'template_soal_kuis.xlsx');
    }

    function normalizeKey(key) {
        return String(key || '')
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '_')
            .replace(/[^a-z0-9_]/g, '');
    }

    function pickField(row, candidates) {
        var map = {};
        Object.keys(row || {}).forEach(function (k) {
            map[normalizeKey(k)] = row[k];
        });
        for (var i = 0; i < candidates.length; i++) {
            var key = normalizeKey(candidates[i]);
            if (map[key] !== undefined && map[key] !== null && String(map[key]).trim() !== '') {
                return String(map[key]).trim();
            }
        }
        return '';
    }

    function parseSoalRows(jsonRows) {
        var result = [];
        (jsonRows || []).forEach(function (row) {
            var pertanyaan = pickField(row, ['pertanyaan', 'soal', 'question', 'nama_soal']);
            if (!pertanyaan) return;

            var jawaban = pickField(row, ['jawaban', 'kunci', 'kunci_jawaban', 'answer']).toLowerCase();
            if (jawaban && jawaban.length > 1) {
                jawaban = jawaban.charAt(0);
            }

            result.push({
                pertanyaan: pertanyaan,
                opsi_a: pickField(row, ['opsi_a', 'a', 'pilihan_a', 'option_a']),
                opsi_b: pickField(row, ['opsi_b', 'b', 'pilihan_b', 'option_b']),
                opsi_c: pickField(row, ['opsi_c', 'c', 'pilihan_c', 'option_c']),
                opsi_d: pickField(row, ['opsi_d', 'd', 'pilihan_d', 'option_d']),
                opsi_e: pickField(row, ['opsi_e', 'e', 'pilihan_e', 'option_e']),
                jawaban: jawaban
            });
        });
        return result;
    }

    function readFileAsJson(file) {
        return new Promise(function (resolve, reject) {
            if (!ensureXLSX()) {
                reject(new Error('XLSX missing'));
                return;
            }
            if (!file) {
                reject(new Error('File kosong'));
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                try {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });
                    var firstSheet = workbook.SheetNames[0];
                    var sheet = workbook.Sheets[firstSheet];
                    var json = XLSX.utils.sheet_to_json(sheet, { defval: '' });
                    resolve(json);
                } catch (err) {
                    reject(err);
                }
            };
            reader.onerror = function () {
                reject(new Error('Gagal membaca file'));
            };
            reader.readAsArrayBuffer(file);
        });
    }

    /**
     * Build and submit form matching existing /tambah-soal endpoint
     * without modifying backend.
     */
    function submitSoalToEndpoint(endpoint, meta, questions, csrfToken) {
        if (!questions || !questions.length) {
            alert('Tidak ada soal valid di file Excel.');
            return;
        }

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = endpoint;
        form.style.display = 'none';

        function addHidden(name, value) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value == null ? '' : value;
            form.appendChild(input);
        }

        addHidden('_token', csrfToken);
        addHidden('kode_kuis', meta.kode_kuis);
        addHidden('id_mapel', meta.id_mapel);
        addHidden('id_guru', meta.id_guru);
        addHidden('durasi', meta.durasi);

        questions.forEach(function (q, index) {
            addHidden('questions[' + index + '][pertanyaan]', q.pertanyaan);
            addHidden('questions[' + index + '][opsi_a]', q.opsi_a);
            addHidden('questions[' + index + '][opsi_b]', q.opsi_b);
            addHidden('questions[' + index + '][opsi_c]', q.opsi_c);
            addHidden('questions[' + index + '][opsi_d]', q.opsi_d);
            addHidden('questions[' + index + '][opsi_e]', q.opsi_e);
            addHidden('questions[' + index + '][jawaban]', q.jawaban);
        });

        document.body.appendChild(form);
        form.submit();
    }

    return {
        exportTable: exportTable,
        exportJson: exportJson,
        downloadTemplateSoal: downloadTemplateSoal,
        parseSoalRows: parseSoalRows,
        readFileAsJson: readFileAsJson,
        submitSoalToEndpoint: submitSoalToEndpoint
    };
})();

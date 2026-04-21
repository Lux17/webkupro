<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<textarea id="editor"></textarea>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

<script>
tinymce.init({
  selector: '#editor',
  height: 400,
  plugins: 'image link media table code lists',
  toolbar: 'undo redo| styles | bold italic underline |alignleft aligncenter alignright | bullist numlist | image media table | code'
});
</script>
</body>

</html>
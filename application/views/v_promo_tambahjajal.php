<!doctype html>
<html>
<head>
    <title>Add TinyMCE to HTML element in CodeIginter</title>
    <!-- TinyMCE script -->
    <script src='https://makitweb.com/demo/codeigniter_tinymce/resources/tinymce/tinymce.min.js'></script>
</head>
<body>
<!-- Form -->
<form method='post' action=''>
    <!-- Textarea -->
    <textarea class='editor' name='content'>

			</textarea>
    <br>
    <input type='submit' value='Submit' name='submit'>
</form>

<!-- Script -->
<script>
    tinymce.init({
        selector:'.editor',
        theme: 'modern',
        height: 200
    });
</script>
</body>
</html>
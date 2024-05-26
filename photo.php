<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form method="post" enctype="multipart/form-data">
        <label for="">Selectionnez une photo:</label>
        <input type="file" name="photo">
        <input type="submit" value="envoyer" name="ok">
    </form>
</body>
<?php
if (isset($_POST['ok'])) {
    echo '<pre>';
    print_r($_FILES['photo']);
    echo '</pre>';
}

?>

</html>
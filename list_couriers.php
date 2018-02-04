<?php
require_once 'lib/Api.php';
$api = new Api();

$back = 'back';

$api->onClick($back, $api::url_operator);

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список курьеров</title>
</head>
<body>
<div align="center">
    <form method="post">
        <p><input type="submit" value="Назад" name="<?= $back ?>"></p>
    </form>
</div>
</body>
</html>
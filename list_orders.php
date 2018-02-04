<?php
require_once 'lib/Api.php';
$api = new Api();

$new = 'new';
$back = 'back';

$api->onClick($new, $api::url_addorder);
$api->onClick($back, $api::url_operator);

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список заказов</title>
</head>
<body>
<div align="center">
    <form method="post">
        <p><input type="submit" value="Новый" name="<?= $new ?>"></p>
        <p><input type="submit" value="Назад" name="<?= $back ?>"></p>
    </form>
</div>
</body>
</html>

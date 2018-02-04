<?php
require_once 'lib/Api.php';
$api = new Api();

//собираем айдишники страницы в одном месте
$orders = 'orders';
$couriers = 'couriers';

//вешаем обработчики кнопок
$api->onClick($orders, $api::url_orders);
$api->onClick($couriers, $api::url_couriers);
$api->onClick($api::exit_name);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Интерфейс оператора</title>
</head>
<body>
<div align="center">
    <h1>Интерфейс оператора</h1>
    <form method="post">
        <p><input type="submit" value="Заказы" name="<?= $orders ?>">
        <input type="submit" value="Курьеры" name="<?= $couriers ?>">
        <input type="submit" value="Выход" name="<?= $api::exit_name ?>"></p>
    </form>
</div>
</body>
</html>
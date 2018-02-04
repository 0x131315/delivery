<?php
require_once 'lib/Api.php';
$api = new Api();

$add = 'add';
$back = 'back';

$api->save($api::ord_desc);
$api->save($api::ord_addr);
$api->save($api::ord_cost);
$api->save($api::ord_time);

$api->onClick($back, $api::url_orders);

if (!empty($_POST[$add])) {
    $api->addOrder();
    unset($_SESSION[$api::ord_desc]);
    unset($_SESSION[$api::ord_addr]);
    unset($_SESSION[$api::ord_cost]);
    unset($_SESSION[$api::ord_time]);
    $api->go_to($api::url_orders);
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить заказ</title>
</head>
<body>
<div>
    <div align="center">
        <fieldset style="width: 60%">
            <legend><b>Добавить новый заказ</b></legend>
            <form method="post">
                <label>Описание заказа: </label>
                <textarea
                        style="width: 95%; text-align: left; resize: vertical"
                        name="<?= $api::ord_desc ?>"
                        autofocus
                        maxlength="65535"
                        rows="15"
                        title="Описание заказа:"><?= $api->load($api::ord_desc) ?></textarea>
                Адрес: <input
                        style="width: 95%"
                        type="text"
                        placeholder="адрес"
                        name="<?= $api::ord_addr ?>"
                        value="<?= $api->load($api::ord_addr) ?>"
                        maxlength="255">
                <p><label style="position: relative; left: -18%">Сумма заказа: </label>
                    <input
                            style="text-align: right; position: relative; left: -17%"
                            type="number"
                            name="<?= $api::ord_cost ?>"
                            value="<?= $api->load($api::ord_cost) ?>"
                            placeholder="рублей"
                            title="рублей"
                            min="0"
                            max="4294967295">
                    <label style="position: relative; left: -15%">Время доставки: </label>
                    <input
                            style="text-align: right; position: relative; left: -14%"
                            type="number"
                            name="<?= $api::ord_time ?>"
                            value="<?= $api->load($api::ord_time) ?>"
                            placeholder="минут"
                            title="минут"
                            min="0"
                            max="65535">
                    <input type="submit" value="Добавить" name="<?= $add ?>" style="position: relative; right: 12%">
                    <input type="submit" value="Назад" name="<?= $back ?>" style="position: relative; right: -18.15%">
                </p>
            </form>
        </fieldset>
    </div>
</div>
</body>
</html>
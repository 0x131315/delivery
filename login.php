<?php
require_once 'lib/Api.php';
$api = new Api('login');

//сохраняем ввод
$api->save($api::login_name);
$api->save($api::pass_name);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Войти</title>
</head>
<body>
<div>
    <div align="center">
        <h1>Вход</h1>
        <form method="post">
            <p><label>Логин:<br>
                    <input name="<?= $api::login_name ?>" size="25" type="text" placeholder="логин"
                           autofocus required value="<?= $api->load($api::login_name) ?>"></label>
            </p>
            <p><label>Пароль:<br>
                    <input name="<?= $api::pass_name ?>" size="25" placeholder="пароль"
                           type="password" required value="<?= $api->load($api::pass_name) ?>"></label>
            </p>
            <p><input type="submit" value="Войти"></p>
        </form>
        <?php $api->getError() ?>
        <p>login/pass: operator/operator, user/user</p>
    </div>
</div>
</body>
</html>
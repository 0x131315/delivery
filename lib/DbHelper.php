<?php
require_once 'Password.php';
require_once 'Db_object.php';

class DbHelper
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    //-----------------Функции-обертки---------------------------------
    public function getUserByCookie($cookie)
    {
        $sql = 'SELECT * FROM users WHERE cookie = ? AND cookie_time > ?';
        $arg = [$cookie, date('Y-m-d H:i:s', time())];
        return $this->db->exec($sql, $arg, Db_users::class);
    }

    public function getUserByPass($login, $pass)
    {
        $sql = 'SELECT * FROM users WHERE login = ? AND pass = ?';
        $arg = [$login, (new Password())->md5pass($pass)];
        return $this->db->exec($sql, $arg, Db_users::class);
    }

    /**
     * @param $user Db_users
     * @return bool|mixed
     */
    public function setCookieByUser($user)
    {
        $sql = 'UPDATE users SET cookie = ? , cookie_time = ? WHERE login = ?';
        $arg = [$user->cookie, $user->cookie_time, $user->login];
        return $this->db->exec($sql, $arg);
    }

    /**
     * @param $order Db_orders
     * @return bool|mixed
     */
    public function addOrder($order)
    {
        $sql = 'INSERT INTO orders SET status = ?, cost = ?, date_start = now(), address = ?, description = ?';
        $arg = [$order->status, $order->cost, $order->address, $order->description];
        return $this->db->exec($sql, $arg);
    }

    /**
     * @param $order_open Db_order_open
     * @return bool|mixed
     */
    public function addOrder_open($order_open)
    {
        $sql = 'INSERT INTO order_open SET order_id = ?, time_way = ?';
        $arg = [$order_open->order_id, $order_open->time_way];
        return $this->db->exec($sql, $arg);
    }


}

class Db //Драйвер бд
{
    private $pdo;

    public function __construct() //connect pdo
    {
        $username = 'root';
        $password = '';

        $options =
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //Включаем исключения
                PDO::ATTR_PERSISTENT => TRUE]; //и кеширование соединений

        $this->pdo = new PDO('mysql:dbname=delivery;host=localhost', $username, $password, $options);
    }

    /**
     * Обращение к БД
     * @param $sql string строка запроса
     * @param $arg array аргументы запроса
     * @param null $class класс возвращаемого обьекта
     * @return bool|mixed ответ
     */
    public function exec($sql, $arg, $class = null)
    {
        $exec = $this->pdo->prepare($sql);
        $exec->execute($arg);

        if (empty($class)) return $this->pdo->lastInsertId();

        $exec->setFetchMode(PDO::FETCH_CLASS, $class);
        return $exec->fetch();
    }
}
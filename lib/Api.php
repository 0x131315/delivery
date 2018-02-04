<?php
require_once 'User_Input.php';
require_once 'DbHelper.php';
require_once 'Cookie.php';

class Api //система авторизации
{
    /** @var Db_users $user */
    private $user;
    private $access;
    private $error;

    //const
    const url_login = 'login.php';
    const url_access = 'access_denied.php';
    const url_operator = 'operators_interface.php';
    const url_orders = 'list_orders.php';
    const url_couriers = 'list_couriers.php';
    const url_addorder = 'add_order.php';

    const ord_desc = 'order_description';
    const ord_addr = 'order_address';
    const ord_cost = 'order_cost';
    const ord_time = 'order_time';

    const login_name = 'login';
    const pass_name = 'password';
    const cookie_name = 'delivery';
    const exit_name = 'exit';

    const cookie_lifetime = 7; //время жизни куки - неделя
    const min_len = 4;
    const max_len = 32;
    const hash_len = 32;

    public function __construct($access = 'auth') //сразу получаем юзера из базы и проверяем доступ
    {
        $this->access = $access;

        if ($access == 'index')
            $this->logIn();

        $this->setSession(); //даем возможность хранить ввод

        //ищем юзера
        $user = $this->getUser();
        $this->user = $user;

        if ($access == 'login' and !empty($user->login))
            $this->signIn();

        if ($access == 'auth') {
            if (empty($user->login))
                $this->logIn();
            $this->checkAccess();
        }
    }

    //------------------------------ обслуживаем процедуры логина

    public function logout($warning = false) //выходим из учетки
    {
        //удаляем старую куку из базы
        $this->user->cookie = (new Cookie())->getNewCookie();
        (new DbHelper())->setCookieByUser($this->user);

        $this->closeSession(); //сносим сессию

        //переходим на страничку логина
        if (empty($warning))
            $this->logIn();
        else
            $this->accessDenied();

        return true;
    }

    public function getError() //обрабатываем ошибки при логине
    {
        if (empty($this->error))
            return false;

        foreach ($this->error as $i)
            echo '<p>' . $i . '</p>';

        return true;
    }

    //------------------------------ переходы по страницам сайта

    private function signIn() //перенаправляем в интерфейс оператора
    {
        if (empty($this->user->login))
            return false;

        $this->go_to(self::url_operator);

        return true;
    }

    public function logIn() //перенаправляем в форму логина
    {
        $this->go_to(self::url_login);
    }

    private function accessDenied() //перенаправляем на предупреждение
    {
        $this->go_to(self::url_access);
    }

    //------------------------------ получаем ввод пользователя

    private function getCookie() //проверяем возможность использовать полученную от юзера куку
    {
        if (empty($_COOKIE[self::cookie_name]))
            return false;

        $cookie = $_COOKIE[self::cookie_name];

        $cookie_len = strlen($cookie) == self::hash_len;
        $cookie_format = (new User_Input())->isCookieValid($cookie);

        $result = $cookie_len and $cookie_format;

        if ($result == false)
            return false;

        return $cookie;
    }

    private function getLogin() //проверяем возможность использовать полученный  от юзера логин
    {
        if (empty($_POST[self::login_name]))
            return false;

        $login = $_POST[self::login_name];

        $login_len = strlen($login) >= self::min_len and strlen($login) <= self::max_len;
        $login_format = (new User_Input())->isLoginValid($login);

        $result = $login_len and $login_format;

        if ($result == false) {
            $this->error[0] = 'Логин: не менее 4х символов</br>a..z, 0..9, знак подчеркивания</br>';
            return false;
        }

        return $login;
    }

    private function getPass() //проверяем возможность использовать полученный от юзера пароль
    {
        if (empty($_POST[self::pass_name]))
            return false;

        $pass = $_POST[self::pass_name];

        $pass_len = strlen($pass) >= self::min_len and strlen($pass) <= self::max_len;
        $pass_format = (new User_Input())->isPasswordValid($pass);

        $result = $pass_len and $pass_format;

        if ($result == false) {
            $this->error[1] = 'Пароль: не менее 4х символов</br>a..z, A..Z, 0..9, знак подчеркивания</br>';
            return false;
        }

        return $pass;
    }

    //------------------------------ работаем с сессиями

    private function setSession() //удерживаем ввод юзера в сессии
    {
        session_set_cookie_params(60 * 60); //даем возможность собирать мусор почаще
        session_start();
    }

    private function closeSession() //уничтожаем сессию
    {
        if (empty(session_name()))
            return false;

        $timestamp = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));

        setcookie(session_name(), '', $timestamp, '/');
        session_unset();
        session_destroy();

        return true;
    }

    public function save($id) //сохраняем переменную в сесии
    {
        if (!empty($_POST[$id]))
            $_SESSION[$id] = $_POST[$id];
    }

    public function load($id) //извлекаем переменную из сессии
    {
        if (!empty($_SESSION[$id]))
            return $_SESSION[$id];
    }

    //------------------------------ служебные функции

    public function onClick($button_id, $url = self::exit_name) //переходим на адрес по клику
    {
        if (!empty($_POST[$button_id]))
            switch ($url) {
                case self::exit_name:
                    $this->logout();
                    break;
                default:
                    $this->go_to($url);
            }
    }

    public function go_to($location) //переходим на указанную страничку
    {
        header('location: ' . $location);
    }

    private function checkAccess() //перенаправляем на логин, если нет доступа
    {
        if ($this->user->status == 2)
            return true;

        $this->logout(true);

        return false;
    }

    private function newCookie($user) //Обновляем куки в базе, обьекте и браузере
    {
        $timestamp = mktime(0, 0, 0, date("m"), date("d") + self::cookie_lifetime, date("Y"));

        $user->cookie = (new Cookie())->getNewCookie();
        $user->cookie_time = date('Y-m-d H:i:s', $timestamp);

        setcookie(self::cookie_name, $user->cookie, $timestamp);
        (new DbHelper())->setCookieByUser($user);

        return true;
        //ошибки не обрабатываем - синхронизируемся авторизацией по паролю
    }

    private function getUser() //получаем юзера из базы
    {
        /**@var Db_users $user */
        $user = null;

        //получаем ввод
        $cookie = $this->getCookie();
        $login = $this->getLogin();
        $pass = $this->getPass();

        //ввод пустой?
        if (empty($cookie) and (empty($login) or empty($pass)))
            return false;

        //получаем юзера по кукам
        if (!empty($cookie))
            $user = (new DbHelper())->getUserByCookie($cookie);
        if (!empty($user->login)) {
            //$this->newCookie($user); //опционально меняем куки каждый вход, обрывая перехваченные сессии
            return $user;
        }

        //кук у юзера нет, получаем юзера по паролю
        $user = (new DbHelper())->getUserByPass($login, $pass);
        if (!empty($user->login)) {
            $this->newCookie($user); //не забываем выдать куки для последующей авторизации
            return $user;
        }

        //не получилось
        if ($this->access == 'login' and !empty($login) and !empty($pass))
            $this->error[3] = 'Неправильно набран номер';

        return false;
    }

    //------------------------------ доступ к данным

    public function addOrder()
    {
        $order = new Db_orders();
        $order->description = $this->load(self::ord_desc);
        $order->address = $this->load(self::ord_addr);
        $order->cost = $this->load(self::ord_cost);
        $order->status = 0;
        $order->id = (new DbHelper())->addOrder($order);

        $order_open = new Db_order_open();
        $order_open->order_id = $order->id;
        $order_open->time_way = $this->load(self::ord_time);
        $id=(new DbHelper())->addOrder_open($order_open);

        return $id;
    }
}
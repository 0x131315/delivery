<?php

class Db_users //учетки пользователей
{
    //----------------описание таблицы---------------------------------
    /* Таблица users, содержащая учетки пользователей
     * login - tinytext unique(32)
     * pass - tinytext
     * cookie - null tinytext index(32)
     * cookie_time - null datetime
     * status - 0 enum 0..2,-1
     */

    //----------------структура таблицы--------------------------------
    public $login; //логин
    public $pass; //хэш пароля
    public $cookie; //кука
    public $cookie_time; //время жизни куки
    public $status; //статус учетки 0-новая, 1-пользователь, 2-оператор, -1-подлежит удалению
}

class Db_orders //заказы
{
    //----------------описание таблицы---------------------------------
    /* Таблица orders - архив заказов, только добавление/изменение
     * id - uint primary ai
     * status - 0 enum 0..3,-1
     * cost - null uint
     * date_start - null datetime
     * date_end - null datetime
     * address - null tinytext
     * description - null text
     */

    //----------------структура таблицы--------------------------------
    public $id; //id заказа
    public $status; //статус заказа 0-новый, 1-назначен курьеру, 2-доставляется, 3-доставлен, -1-отменен
    public $cost; //стоимость заказа
    public $date_start; //дата фактического открытия заказа
    public $date_end; //дата фактического закрытия заказа
    public $address; //адрес доставки
    public $description; //описание заказа
}

class Db_order_open //активные заказы
{
    /* Таблица order_open - открытые заказы, добавление/удаление
    * order_id - uint uniq
    * time_way - null usmallint
    * courier_id - null uint
    * date_es - null datetime
    */

    //структура таблицы order_open
    public $order_id; //id заказа в таблице orders
    public $time_way; //время пути для курьера (null - самовывоз)
    public $courier_id; //id курьер, которому назначен заказ (null - самовывоз)
    public $date_es; //ожидаемая дата доставки
}

class Db_couriers //курьеры
{
    /* Таблица couriers - список курьеров, только добавление/изменение
     * id - uint primary ai
     * name - null tinytext
     * description - null tinytext
     * status - 0 enum 0,1,-1
     * shedule - null uint
     */

    //структура таблицы couriers
    public $id; //id курьера
    public $name; //имя курьера
    public $description; //описание курьера
    public $status; //статус курьера 0-не работает, 1-работает, -1-уволен
    public $shedule; //расписание работы и отдыха (day time time)
}

class Db_couriers_shedule //курьеры
{
    /* Таблица couriers_shedule - расписание курьеров
     * id - uint primary ai
     * Mo - 0 bit
     * Tu - 0 bit
     * We - 0 bit
     * Th - 0 bit
     * Fr - 0 bit
     * Sa - 0 bit
     * Su - 0 bit
     * Mo_start - null utinyint
     * Tu_start - null utinyint
     * We_start - null utinyint
     * Th_start - null utinyint
     * Fr_start - null utinyint
     * Sa_start - null utinyint
     * Su_start - null utinyint
     * Mo_end - null utinyint
     * Tu_end - null utinyint
     * We_end - null utinyint
     * Th_end - null utinyint
     * Fr_end - null utinyint
     * Sa_end - null utinyint
     * Su_end - null utinyint
     */

    //структура таблицы couriers_shedule
    public $id; //ключ
    public $Mo; //бит, 0 - выходной
    public $Tu;
    public $We;
    public $Th;
    public $Fr;
    public $Sa;
    public $Su;
    public $Mo_start; //часы начала работы
    public $Tu_start;
    public $We_start;
    public $Th_start;
    public $Fr_start;
    public $Sa_start;
    public $Su_start;
    public $Mo_end; //часы окончания работы
    public $Tu_end;
    public $We_end;
    public $Th_end;
    public $Fr_end;
    public $Sa_end;
    public $Su_end;
}
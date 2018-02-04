<?php

class Password
{
    /** получаем хэш пароля
     * @param $pass - пароль
     * @return string - хэш пароля
     */
    public function md5pass($pass){
        $pass = md5($pass);
        $salt = md5('password');
        $result = md5($pass.$salt);
        return $result;
    }
}
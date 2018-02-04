<?php

class User_Input
{
    /*Соглашение о вводе:
     * Логин - до 32х символов, английский алфавит, нижний регистр, цифры, знак подчеркивания
     * Пароль - до 32х символов, английский алфавит, любой регистр, цифры, знак подчеркивания
     * Куки - до 32х символов, английский алфавит, любой регистр, цифры
     */

    /** Фильтрация логина
     * @param $string - проверяемая строка
     * @return bool - результат проверки
     */
    public function isLoginValid($string)
    {
        //проверка на регистр
        if (strcmp($string, strtolower($string)) <> 0)
            return false;

        static $mask;
        if (is_null($mask)) {
            //если маска пуста
            //заполняем маску фильтра
            //формат: цифры, буквы, знак подчеркивания
            $mask['_'] = TRUE;
            foreach (range('0', '9') as $i) $mask[$i] = TRUE;
            foreach (range('a', 'z') as $i) $mask[$i] = TRUE;
        }

        //str2array
        $array = str_split($string, 1);

        $result = null;
        foreach ($array as $i) {
            //для каждой буквы в строке ищем совпадение в маске-словаре
            //из всех совпавших символов собираем строку
            if (isset($mask[$i]))
                $result .= $i;
        }

        //если строки одинаковы, значит лишних символов нет, возвращаем true
        return !strcmp($string, $result);
    }

    /** Фильтрация пароля
     * @param $string - проверяемая строка
     * @return bool - результат проверки
     */
    public function isPasswordValid($string)
    {
        //логин и пароль отличаются регистром
        //приводим пароль к регистру логина
        $string = strtolower($string);
        //отдаем фильтру логина
        return $this->isLoginValid($string);
    }

    /** Фильтрация куки
     * @param $string - проверяемая строка
     * @return bool - результат проверки
     */
    public function isCookieValid($string)
    {
        //кука и пароль отличаются знаком подчеркивания
        //отдаем куку фильтру пароля
        return $this->isPasswordValid($string);
    }


}
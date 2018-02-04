<?php

class Cookie
{

    /**Генератор новых хэш-кук
     * @param int $len - длина хэша
     * @return string - готовый хэш
     */
    private function getHashRnd($len = 32)
    {
        static $dictionary;
        static $dic_end;

        if (empty($dictionary)) {
            foreach (range('0', '9') as $i) $dictionary .= $i;
            foreach (range('a', 'z') as $i) $dictionary .= $i;
            foreach (range('0', '9') as $i) $dictionary .= $i;
            foreach (range('A', 'Z') as $i) $dictionary .= $i;

            $dic_end = strlen($dictionary) - 1;
        }

        $hash = null;
        $hash_len = 0;
        {
            while ($hash_len < $len) {
                $rnd_num = mt_rand(0, $dic_end);
                $hash .= $dictionary[$rnd_num];
                $hash_len = strlen($hash);
            }
        }

        return $hash;
    }

    /** Возвращает новую куку
     * @return string - новая кука
     */
    public function getNewCookie()
    {
        return $this->getHashRnd();
    }


}
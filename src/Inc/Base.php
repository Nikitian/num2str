<?php


namespace Nikitian\Num2str\Inc;


abstract class Base
{
    /**
     * @param string $string
     * @return string
     * @throws \Exception
     */
    static public function convert($string)
    {
        throw new \Exception('Need realize method ' . __METHOD__ . ' for convert ' . $string);
    }

    /**
     * @param string $digit
     * @param array(3) $main
     * @param array(3) $second
     * @return string
     * @throws \Exception
     */
    protected static function _money($digit, $main, $second)
    {
        throw new \Exception('Need realize method ' . __METHOD__, sizeof([$digit] + $main + $second));
    }

    /**
     * Convert money
     * @param string $digit
     * @param array $main   array('доллар', 'доллара', 'долларов')
     * @param array $second array('цент', 'цента', 'центов')
     * @return string
     */
    public static function money($digit, $main = [], $second = [])
    {
        if (empty($main)) {
            $main = static::$valute['main'];
        }
        if (empty($second)) {
            $second = static::$valute['second'];
        }
        return static::_money($digit, $main, $second);
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    protected static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }
        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }
        if ($n == 1) {
            return $f1;
        }
        return $f5;
    }


    protected static $valute = [
        'main' => [],
        'second' => [],
    ];


    /**
     * @param mixed $main string or array for main currency name
     * @param mixed $second string or array for second currency name
     * @return bool
     * @throws \Exception
     */
    public static function setCurrency($main, $second)
    {
        if (is_string($main)) {
            static::$valute['main'] = [$main, $main, $main];
        } elseif(is_array($main)) {
            static::$valute['main'] = [
                array_key_exists(0, $main)?$main[0]:reset($main),
                array_key_exists(1, $main)?$main[1]:reset($main),
                array_key_exists(2, $main)?$main[2]:reset($main),
            ];
        } else {
            throw new \Exception('Main value need');
        }

        if (is_string($second)) {
            static::$valute['second'] = [$second, $second, $second];
        } elseif(is_array($second)) {
            static::$valute['second'] = [
                array_key_exists(0, $second)?$second[0]:reset($second),
                array_key_exists(1, $second)?$second[1]:reset($second),
                array_key_exists(2, $second)?$second[2]:reset($second),
            ];
        } else {
            throw new \Exception('Second value need');
        }
        return true;
    }
}

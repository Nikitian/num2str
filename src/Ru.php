<?php
namespace Nikitian\Num2str;
use Nikitian\Num2str\Inc\Base;

class Ru extends Base
{
    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses morph(...)
     * @param string $num
     * @param bool $isMoney
     * @param array $main
     * @param array $second
     * @return string
     */
    public static function num2str($num, $isMoney = false, $main = [], $second = [])
    {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array(
            'десять',
            'одиннадцать',
            'двенадцать',
            'тринадцать',
            'четырнадцать',
            'пятнадцать',
            'шестнадцать',
            'семнадцать',
            'восемнадцать',
            'девятнадцать'
        );
        $tens = array(
            2 => 'двадцать',
            'тридцать',
            'сорок',
            'пятьдесят',
            'шестьдесят',
            'семьдесят',
            'восемьдесят',
            'девяносто'
        );
        $hundred = array(
            '',
            'сто',
            'двести',
            'триста',
            'четыреста',
            'пятьсот',
            'шестьсот',
            'семьсот',
            'восемьсот',
            'девятьсот'
        );
        $unit = array(// Units
            array($second[0], $second[1], $second[2], 1),
            array($main[0], $main[1], $main[2], 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                }# 20-99
                else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                }# 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = static::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            } //foreach
        } else {
            $out[] = $nul;
        }
        if ($isMoney) {
            $out[] = static::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        }
        if ($kop > 0) {
            $out[] = $kop . ($isMoney ? (' ' . static::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2])) : ''); // kop
        }
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    public static function convert($string)
    {
        return static::num2str($string);
    }

    public static function _money($digit, $main, $second)
    {
        return static::num2str($digit, true, $main, $second);
    }

}

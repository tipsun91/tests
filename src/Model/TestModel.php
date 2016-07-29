<?php

namespace App\Model;


use App\Component\Model;


class TestModel extends Model
{
    public function getText()
    {
        return <<<TEXT
1) Дан текст с включенными в него тегами следующего вида:
[НАИМЕНОВАНИЕ_ТЕГА1:описание1]данные1[/НАИМЕНОВАНИЕ_ТЕГА1]
[НАИМЕНОВАНИЕ_ТЕГА2:описание2]данные2[/НАИМЕНОВАНИЕ_ТЕГА2]
[НАИМЕНОВАНИЕ_ТЕГА3]данные3[/НАИМЕНОВАНИЕ_ТЕГА3]
[НАИМЕНОВАНИЕ_ТЕГА4][/НАИМЕНОВАНИЕ_ТЕГА4]
[НАИМЕНОВАНИЕ_ТЕГА4:][/НАИМЕНОВАНИЕ_ТЕГА4]

На выходе нужно получить 2 массива:
raz:Первый:
* Ключ - наименование тега
* Значение - данные 
dvaВторой:
* Ключ - наименование тега
* Значение - описание

triВложенность тегов не допускается.
Описания может и не быть
chetire:Обезателен закрвающий тег
TEXT;
    }

    public function tag($text)
    {
        // $regex = '#\[([^\:]+)\:*([^\]]*)\]([^\[]+)\[\/\\1\]#uis';
        $regex = '#\[(\w+)\:*(\w*)\](\w+)\[\/\\1\]#uis';

        $tt = [];
        $td = [];

        if(preg_match_all($regex, $text, $array)) {
            foreach ($array[1] as $key => $value) {
                $tt[] = [
                    $value => $array[3][$key],
                ];
                $td[] = [
                    $value => $array[2][$key],
                ];
            }
        }

        return [
            'tagWithText'        => $tt,
            'tagWithDescription' => $td,
        ];
    }

    public function key($text)
    {
//        $lastKeyPosition = mb_strrpos(); /* || strrpos(); */
        $keyWords = ['raz', 'dva', 'tri', 'chetire'];
        $pattern = implode('|', $keyWords);
        $regex = "#({$pattern}):#uis";

        $result = [];

        if(preg_match_all($regex, $text, $array, PREG_OFFSET_CAPTURE)) {
            $keys = &$array[1];
            foreach($keys as $key => $value) {
                list($tag, $pos) = $value;
                $pos += strlen($array[0][$key][0]);
                $length = isset($keys[($key+1)][1]) ? $keys[($key+1)][1]-$pos : 0;
                if ($length) {
                    $result[$tag] = substr($text, $pos, $length);
                } else {
                    $result[$tag] = substr($text, $pos);
                }
            }
        }

        return $result;
    }

    public function getClones()
    {
        $array = [];
        for ($i = 0, $j = 1000000; $i < $j; $i++) {
            $array[$i] = mt_rand(100000, 1500000);
        }

        $st = microtime(true);

        $result = [];
        $flip = [];
        foreach ($array as $key => $value) {
            if (isset($flip[$value])) {
                $result[$value] = true;
            } else {
                $flip[$value] = true;
            }
        }

        $sp = round(microtime(true) - $st, 5);

        unset($array, $flip);

        return ['stopwatch' => $sp, 'content' => $result];
    }

    public function getCombinations(array $array)
    {
        $result = null;

        foreach ($array as $key => $value) {
            if (null === $result) {
                $result = $value;
            } else {
                $result = $this->cartesianProduct($result, $value);
            }
        }

        return $result;
    }

    private function cartesianProduct($a, $b)
    {
        $result = [];

        foreach ($a as $ak => $av) {
            foreach ($b as $bk => $bv) {
                $result[] = array_merge(
                    (is_array($av) ? $av : [$av]),
                    (is_array($bv) ? $bv : [$bv])
                );
            }
        }

        return $result;
    }
}

<?php

namespace App\Contrast;
function contrastJson($path1, $path2)
{
    $arr1 = json_decode(file_get_contents(__DIR__ . $path1), true);
    $arr2 = json_decode(file_get_contents(__DIR__ . $path2), true);
    $arrKeys = array_keys(array_merge($arr1, $arr2));
    sort($arrKeys);
    $result = array_reduce($arrKeys, function ($acc, $key) use ($arr1, $arr2)
    {
        if (isset($arr1[$key]) && isset($arr2[$key])) {
            if ($arr1[$key] === $arr2[$key]) {
                $acc .= "   {$key}: {$arr1[$key]}\n"; 
                return $acc;
            }
            $acc .= " - {$key}: {$arr1[$key]}\n";
            $acc .= " + {$key}: {$arr2[$key]}\n";
            return $acc;
        }
        if (isset($arr1[$key]) && !isset($arr2[$key])) {
            $acc .= " - {$key}: {$arr1[$key]}\n";
        }
        if (!isset($arr1[$key]) && isset($arr2[$key])) {
            $acc .= " + {$key}: {$arr2[$key]}\n";
        }
        return $acc;
    }, "");
    return "{\n{$result}\n}";
}
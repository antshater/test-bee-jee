<?php


namespace Core\Helpers;

class ArrayHelper
{
    public static function extract($data, $path)
    {
        if (!$path) {
            return $data;
        }

        foreach (explode('.', $path) as $part) {
            $data = $data && isset($data[$part]) ? $data[$part] : null;
        }

        return $data;
    }
}

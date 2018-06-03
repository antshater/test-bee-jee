<?php


namespace Core\Helpers;

class Html
{
    public static function a(string $link, string $label, $params = [], $attributes = [], $overrideParams = false)
    {
        $currentParams = $_GET;
        $params = $overrideParams ? $params : array_merge($currentParams, $params);
        $href = $link . '?' . http_build_query($params);
        $attributes_parts = array_map(function ($name) use ($attributes) {
            return "$name='{$attributes[$name]}'";
        }, array_keys($attributes));
        $attributesString = implode(' ', $attributes_parts);
        return "<a href='$href' $attributesString >$label</a>";
    }
}

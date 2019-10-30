<?php

namespace Orq\DddBase;

trait FieldToPropertyTrait
{
    /**
     * Substitute 'cover_image' to 'coverImage'
     */
    static function toProperty(string $k): string
    {
        if (strpos($k, '_')) {
            $k = preg_replace_callback('/_([a-z])/', function ($matches) {
                return strtoupper($matches[1]);
            }, $k);
        }
        return $k;
    }

    /**
     * Substitute 'coverImage' to 'cover_image'
     */
    static function toField(string $str): string
    {
        $str = lcfirst($str);
        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);

        return $str;
    }
}

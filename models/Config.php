<?php

class Config {
    public static function convertStd($data) {
        if (is_array($data)) {
            $object = new stdClass();
            foreach ($data as $key => $value) {
                $object->$key = self::convertStd($value);
            }
            return $object;
        } elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                $data->$key = self::convertStd($value);
            }
            return $data;
        } else {
            return $data;
        }
    }
    public static function tino() {
        $data = [
            'baseUrl' => 'https://my.tino.org/api',
            'timeout' => 30,
            'pricing' => [
                'baseUrl' => 'https://api.tino.vn/',
                'endpoint' => 'cart/domain/tlds',
            ]
        ];
        return self::convertStd($data);
    }
}
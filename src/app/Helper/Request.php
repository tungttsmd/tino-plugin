<?php

namespace Helper;

class Request
{
    use Maker;
    public function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
    public function post($key, $default = null)
    {
        // Xử lý vấn đề Ajax POST gửi null nhưng vẫn decode thàn string null
        if ($_POST[$key] === "null") {
            $_POST[$key] = $default;
        }
        return $_POST[$key] ?? $default;
    }
}

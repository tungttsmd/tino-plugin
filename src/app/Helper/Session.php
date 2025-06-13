<?php

namespace Helper;

class Session
{
    use Maker;
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

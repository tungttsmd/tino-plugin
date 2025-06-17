<?php

namespace Helper;

use Throwable;
use Helper\ExceptionHandler;

trait Maker
{
    public static function make(...$args): self
    {
        return new self(...$args);
    }
}

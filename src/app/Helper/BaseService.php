<?php
namespace App\Helper;
trait BaseService
{
    public static function make(...$args): self
    {
        return new self(...$args);
    }
}

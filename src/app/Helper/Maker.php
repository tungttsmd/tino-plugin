<?php

namespace Helper;

trait Maker
{
    public static function make(...$args): self
    {
        return new self(...$args);
    }
}

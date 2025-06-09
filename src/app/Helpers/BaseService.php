<?php
trait BaseService
{
    public static function make(...$args): self
    {
        return new self(...$args);
    }
}

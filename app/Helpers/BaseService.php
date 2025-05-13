<?php
trait BaseService
{
    public static function make(): self
    {
        return new self();
    }
}

<?php

namespace Helper;

class Tool
{
    use Maker;
    public static function oopstd($mixList)
    {
        if (is_array($mixList)) {
            $object = new \stdClass();
            foreach ($mixList as $key => $value) {
                $object->$key = self::oopstd($value);
            }
            return $object;
        } elseif (is_object($mixList)) {
            foreach ($mixList as $key => $value) {
                $mixList->$key = self::oopstd($value);
            }
            return $mixList;
        } else {
            return $mixList;
        }
    }
}

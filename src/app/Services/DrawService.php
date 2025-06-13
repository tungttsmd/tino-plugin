<?php
namespace App\Services;

use Helper\Maker;

class DrawService
{
    use Maker;
    private $widget = [];

    public function data($data)
    {
        $this->widget = $data;
        return $this;
    }
    public function widget()
    {
        return $this->widget;
    }
}

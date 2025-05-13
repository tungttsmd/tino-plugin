<?php
class DrawService
{
    use BaseService;
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

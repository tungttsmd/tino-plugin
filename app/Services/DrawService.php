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
    public function merge($arrayWithKey)
    {
        $this->widget = array_merge((array) $this->widget, (array) $arrayWithKey);
        return $this;
    }
}

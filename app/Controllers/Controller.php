<?php
class Controller
{
    public function render($renderPath, $data)
    {
        # $data will import into html here. use $data directly
        include dirname(dirname(plugin_dir_path(__FILE__))) . "/views/$renderPath.php";
    }
}

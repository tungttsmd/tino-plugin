<?php

namespace Includes;

use Includes\Ajax\AjaxActionRegister;
use Includes\Assets\EnqueueScriptRegister;
use Includes\Shortcodes\ShortcodeRegister;
use Model\Session;

class Plugin
{
    public function __construct()
    {
        Session::make();
        $enqueue = new EnqueueScriptRegister();
        $shortcode = new ShortcodeRegister();
        $ajaxAction = new AjaxActionRegister();
    }
}

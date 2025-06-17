<?php

namespace Includes;

use Helper\Session;
use Includes\Ajax\AsyncRegister;
use Includes\Assets\EnqueueRegister;
use Includes\Shortcodes\ShortcodeRegister;

class Plugin
{
    public function __construct()
    {
		session_force();
        $enqueue = new EnqueueRegister();
        $shortcode = new ShortcodeRegister();
        $ajaxAction = new AsyncRegister();
    }
}

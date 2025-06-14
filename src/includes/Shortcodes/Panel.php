<?php

namespace Includes\Shortcodes;

use Controller\SyncController;

class Panel
{
    public function __construct()
    {
        echo SyncController::make()->panel();
    }
}

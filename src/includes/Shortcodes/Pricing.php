<?php

namespace Includes\Shortcodes;

class Pricing
{
    public function render()
    {
        $tableHeight = 102 + 42 * CONFIG_TABLE_HEIGHT;
        $iframeSrc = plugins_url('src/app/Views/tinoDomainPricing.php', dirname(__FILE__, 3)); // Tạo URL đúng cho file widget_pricing.php
        return '<iframe id="myIframe" src="' . $iframeSrc . '" width="100%" style="height: ' . $tableHeight . 'px; border: none;"></iframe>';
    }
}

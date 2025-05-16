<?php
function javascript_include_wp_style()
{
    $plugin_js_path = dirname(dirname(plugin_dir_url(__FILE__))) . '/views/javascriptsMVC/app/';

    wp_enqueue_script('enqPack', $plugin_js_path . 'Models/Pack.js', array('jquery'), null, true);
    wp_enqueue_script('enqPackBuilder', $plugin_js_path . 'Builders/PackBuilder.js', array('enqPack'), null, true);
    wp_enqueue_script('enqAjaxPackSender', $plugin_js_path . 'Services/AjaxPackSender.js', array('jquery'), null, true);
    wp_enqueue_script('enqAjaxPackHandler', $plugin_js_path . 'Services/AjaxPackHandler.js', array('jquery'), null, true);
    wp_enqueue_script('enqConfigJS', dirname(dirname(plugin_dir_url(__FILE__))) . '/views/javascriptsMVC/config.js', array('enqPack', 'enqPackBuilder', 'enqAjaxPackHandler'), null, true);
    wp_enqueue_script('enqDomainOrderStyle', $plugin_js_path . 'Styles/DomainOrderStyle.js', array('jquery'), null, true);
    wp_enqueue_script('enqButtonAction', $plugin_js_path . 'Actions/ButtonAction.js', array('jquery', 'enqDomainOrderStyle'), null, true);
    wp_enqueue_script('enqButtonBinder', $plugin_js_path . 'Binders/ButtonBinder.js', array('enqButtonAction'), null, true);
    wp_enqueue_script('enqButtonController', $plugin_js_path . 'Controllers/ButtonController.js', array('enqButtonBinder'), null, true);
    wp_enqueue_script('enqIndexJS', dirname(dirname(plugin_dir_url(__FILE__))) . '/views/javascriptsMVC/index.js', array('enqButtonBinder'), null, true);

    // Đưa URL wp-admin ajax vào JavaScript (Sử dụng wp_localize_script() để truyền biến PHP sang JS → chuẩn WordPress.)
    # Truyền biến PHP vào vào javascript (xài trong code front-end js khi khởi tạo) 
    wp_localize_script('enqConfigJS', 'indexPackJs', array(
        'adminAjaxUrl' => admin_url('admin-ajax.php') // URL của admin-ajax.php
    ));
}

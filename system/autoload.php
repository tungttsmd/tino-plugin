<?php
require_once(dirname(plugin_dir_path(__FILE__)) . '/lib/lib.php'); # bắt buộc
require_once(dirname(plugin_dir_path(__FILE__)) . '/core/core.php'); # yêu cầu lib
require(dirname(plugin_dir_path(__FILE__)) . '/config.php');
core_autoload(); # yêu cầu core

spl_autoload_register(function ($classNameWillBeReturnedHere) {
    $className = $classNameWillBeReturnedHere;

    // Start from index.php
    $path_app_builder = dirname(plugin_dir_path(__FILE__)) . "/app/Builders/$className.php";
    $path_app_models = dirname(plugin_dir_path(__FILE__)) . "app/Models/$className.php";
    $path_app_repository_business = dirname(plugin_dir_path(__FILE__)) . "/app/Repository/Business/$className.php";
    $path_app_repository_system = dirname(plugin_dir_path(__FILE__)) . "/app/Repository/System/$className.php";
    $path_app_service = dirname(plugin_dir_path(__FILE__)) . "/app/Services/$className.php";
    $path_app_helper = dirname(plugin_dir_path(__FILE__)) . "/app/Helpers/$className.php";
    $path_app_action = dirname(plugin_dir_path(__FILE__)) . "/app/Actions/$className.php";
    $path_app_controller = dirname(plugin_dir_path(__FILE__)) . "/app/Controllers/$className.php";

    if (file_exists($path_app_builder)) {
        include $path_app_builder;
    };
    if (file_exists($path_app_models)) {
        include $path_app_models;
    };
    if (file_exists($path_app_repository_system)) {
        include $path_app_repository_system;
    };
    if (file_exists($path_app_repository_business)) {
        include $path_app_repository_business;
    };

    if (file_exists($path_app_service)) {
        include $path_app_service;
    };
    if (file_exists($path_app_helper)) {
        include $path_app_helper;
    };
    if (file_exists($path_app_action)) {
        include $path_app_action;
    };
    if (file_exists($path_app_controller)) {
        include $path_app_controller;
    };
});

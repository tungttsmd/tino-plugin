<?php

$baseDir = dirname(__DIR__, 1);
$inputDirCss = $baseDir . '/resource/css';
$inputDirJs = $baseDir . '/resource/js';
$outputFileCss = $baseDir . '/public/css/tino-plugin.css';
$outputFileJs = $baseDir . '/public/js/tino-plugin.js';

function ensureDirectoryExists($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

// Tạo thư mục output nếu chưa có
ensureDirectoryExists(dirname($outputFileCss));
ensureDirectoryExists(dirname($outputFileJs));

// Hàm gộp file CSS
function combineCssFiles($inputDir, $outputFile) {
    $files = glob($inputDir . '/*.css') ?: [];
    $combined = "";

    foreach ($files as $file) {
        $combined .= "/* === " . basename($file) . " === */\n";
        $combined .= file_get_contents($file) . "\n\n";
    }

    file_put_contents($outputFile, $combined);
}

// Hàm gộp file JS
function combineJsFiles($inputDir, $outputFile) {
    $files = glob($inputDir . '/*.js') ?: [];
    $combined = "";

    foreach ($files as $file) {
        $combined .= "// === " . basename($file) . " === //\n";
        $combined .= file_get_contents($file) . "\n\n";
    }

    file_put_contents($outputFile, $combined);
}

// Thực thi gộp
combineCssFiles($inputDirCss, $outputFileCss);
combineJsFiles($inputDirJs, $outputFileJs);

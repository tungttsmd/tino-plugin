<?php

namespace Helper;

use Throwable;

class Catcher
{
    public static function handle(Throwable $e): void
    {
        // Ghi log nếu cần
        error_log($e);

        echo "<style>
            .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            }

            .error-box {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            border-top: 6px solid #dc3545;
            }

            .error-box h2 {
            color: #dc3545;
            margin-bottom: 10px;
            }

            .error-box p {
            color: #333;
            margin-bottom: 20px;
            }

            .error-box button {
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            }

            .error-box button:hover {
            background-color: #c82333;
            }
        </style>";

        // Hiển thị HTML thông báo (bạn có thể thay bằng redirect, JSON hoặc custom error page)
        view("system/catch", ["error" => $e]);
    }
}

<?php

use Helper\Tool;
use Helper\Session;
use Helper\View;

/**
 * Helper function chuyển mảng hoặc object sang stdClass đệ quy.
 *
 * @param array|object $data Dữ liệu đầu vào.
 * @return stdClass|mixed Đối tượng stdClass hoặc giá trị gốc nếu là vô hướng.
 */
function std(array|object $data)
{
    return Tool::convertToStdObject($data);
}

/**
 * Render một view và trả về HTML hoặc in trực tiếp.
 *
 * @param string $template Tên file view (ví dụ: 'invoicePrint')
 * @param array $data Mảng dữ liệu truyền vào view (biến sẽ có thể dùng trong file view)
 * @param bool $return Nếu true sẽ return HTML, nếu false sẽ echo trực tiếp
 * @return string|void Trả về string HTML nếu $returnMode = true, ngược lại in trực tiếp và không trả về gì
 */
function view(string $template, array $data = [], bool $return = false)
{
    // Đặt đường dẫn gốc tới thư mục chứa view
    View::setBasePath(dirname(__DIR__, 3) . '/src/resource/view');

    // Render và in hoặc trả về nội dung HTML
    if ($return) {
        return View::render($template, $data);
    }

    echo View::render($template, $data);
}

/**
 * Helper lấy session với key (đã khởi tạo session ẩn)
 * Lấy giá trị từ session theo key.
 * Hỗ trợ cú pháp dot notation (VD: "user.profile.name").
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function session_get(string $key, mixed $default = null): mixed
{
    return Session::get($key, $default);
}

/**
 * Helper tạo session với key (đã khởi tạo session ẩn)
 * Gán giá trị cho session theo key.
 * Hỗ trợ cú pháp dot notation (VD: "cart.items.0.name").
 *
 * @param string $key
 * @param mixed $value
 * @return void
 */
function session_set(string $key, mixed $value): void
{
    Session::set($key, $value);
}

/**
 * Xoá giá trị trong session theo key.
 * Hỗ trợ cú pháp dot notation. 
 * 
 * @param string $key
 * @return void
 */
function session_remove(string $key): void
{
    Session::remove($key);
}

/**
 * Xoá toàn bộ session hiện tại và hủy session.
 *
 * @return void
 */
function session_clear(): void
{
    Session::clear();
}

/**
 * Kiểm tra session hiện tại đã được khởi động chưa.
 *
 * @return bool
 */
function session_is_started(): bool
{
    return Session::isStarted();
}

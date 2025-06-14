<?php

namespace Helper;

/**
 * Class View
 *
 * Quản lý việc render template PHP với dữ liệu truyền vào.
 */
class View
{
    /**
     * Thư mục gốc chứa các file template.
     * Có thể set để thay đổi vị trí view folder.
     *
     * @var string
     */
    protected static string $basePath;

    /**
     * Đặt thư mục gốc chứa view (nên sử dụng đường path tuyệt đối)
     *
     * @param string $path
     * @return void
     */
    public static function setBasePath(string $path): void
    {
        self::$basePath = rtrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Render template PHP với dữ liệu truyền vào.
     *
     * @param string $template Đường dẫn file template, ví dụ: 'user/profile.php' hoặc 'invoice'
     * @param array $data Mảng dữ liệu có key truyền vào template
     * @return string HTML kết quả render
     *
     * @throws \Exception Nếu file template không tồn tại
     */
    public static function render(string $template, array $data = []): string
    {
        // Nếu basePath chưa set, mặc định là thư mục views trong src/app/Views
        if (!isset(self::$basePath)) {
            self::$basePath = dirname(__DIR__, 3) . '/src/resource/view';
        }

        // Nếu không có đuôi .php thì tự thêm
        if (pathinfo($template, PATHINFO_EXTENSION) !== 'php') {
            $template .= '.php';
        }

        // Tạo đường dẫn tuyệt đối tới file view
        $file = self::$basePath . DIRECTORY_SEPARATOR . $template;

        if (!file_exists($file)) {
            throw new \Exception("View file không tồn tại: {$file}");
        }
        // Extract biến từ mảng data ra biến riêng để dùng trong file view
        extract($data);

        // Bắt đầu đệm output
        ob_start();

        // Include file view để render
        include $file;

        // Lấy nội dung đệm và xóa đệm
        return ob_get_clean();
    }
}

<?php

namespace Helper;

/**
 * Class Session
 *
 * Quản lý session PHP theo kiểu static.
 * Tự động khởi động session nếu chưa bật.
 * Hỗ trợ truy cập key đa cấp thông qua cú pháp dot notation giống Laravel.
 */
class Session
{
    /**
     * Đảm bảo session đã được khởi động.
     * Tự động được gọi trước mọi thao tác session.
     *
     * @return void
     */
    private static function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Lấy giá trị từ session theo key.
     * Hỗ trợ cú pháp dot notation (VD: "user.profile.name").
     *
     * @param string $key     Khóa session cần lấy
     * @param mixed  $default Giá trị trả về nếu không tìm thấy
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::ensureStarted();

        $segments = explode('.', $key);
        $value = $_SESSION;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Gán giá trị cho session theo key.
     * Hỗ trợ cú pháp dot notation (VD: "cart.items.0.name").
     *
     * @param string $key   Khóa session cần gán
     * @param mixed  $value Giá trị cần lưu
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        self::ensureStarted();

        $segments = explode('.', $key);
        $ref = &$_SESSION;

        foreach ($segments as $segment) {
            if (!isset($ref[$segment]) || !is_array($ref[$segment])) {
                $ref[$segment] = [];
            }
            $ref = &$ref[$segment];
        }

        $ref = $value;
    }

    /**
     * Xoá giá trị trong session theo key.
     * Hỗ trợ cú pháp dot notation.
     *
     * @param string $key Khóa session cần xóa
     * @return void
     */
    public static function remove(string $key): void
    {
        self::ensureStarted();

        $segments = explode('.', $key);
        $ref = &$_SESSION;

        while (count($segments) > 1) {
            $segment = array_shift($segments);

            if (!isset($ref[$segment]) || !is_array($ref[$segment])) {
                return;
            }

            $ref = &$ref[$segment];
        }

        unset($ref[array_shift($segments)]);
    }

    /**
     * Xoá toàn bộ session hiện tại và hủy session.
     *
     * @return void
     */
    public static function clear(): void
    {
        self::ensureStarted();
        session_unset();
        session_destroy();
    }

    /**
     * Kiểm tra session hiện tại đã được khởi động chưa.
     *
     * @return bool True nếu session đã khởi động, ngược lại là false
     */
    public static function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }
	
	/**
     * Khởi động cứng session.
     * Tự động được gọi trước mọi thao tác session.
     *
     * @return void
     */
    public static function session_force(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

<?php

namespace Helper;

class Tool
{
    /**
     * Đệ quy chuyển đổi một mảng hoặc đối tượng thành một đối tượng stdClass.
     *
     * Phương pháp này duyệt sâu vào các mảng và đối tượng,
     * chuyển đổi tất cả các mảng lồng nhau thành các đối tượng stdClass,
     * trong khi vẫn bảo toàn các đối tượng hiện có bằng cách đệ quy chuyển đổi các thuộc tính của chúng.
     *
     * @param mixed $data Dữ liệu đầu vào có thể là mảng, đối tượng hoặc số vô hướng.
     * @return \stdClass|mixed Đối tượng stdClass đã chuyển đổi hoặc giá trị vô hướng ban đầu (nếu không phải object hay mảng).
     */
    public static function convertToStdObject(mixed $data)
    {
        if (is_array($data)) {
            $object = new \stdClass(); // Nếu đầu vào là một mảng, sẽ tạo một đối tượng stdClass mới
            // Đệ quy chuyển đổi từng giá trị
            foreach ($data as $key => $value) {
                $object->$key = self::convertToStdObject($value);
            }
            return $object;
        } elseif (is_object($data)) {
            // Nếu đầu vào là một đối tượng, sẽ chuyển đổi đệ quy các thuộc tính của nó
            foreach ($data as $key => $value) {
                $data->$key = self::convertToStdObject($value);
            }
            return $data;
        }
        return $data; // Nếu là số vô hướng hoặc các kiểu khác, trả về nguyên trạng
    }
}

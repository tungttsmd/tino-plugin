<?php

# Hàm kiểm tra giá trị falsy tốt hơn empty() mặc định (rỗng = true)
function betterEmpty($value): bool
{
    if (is_string($value)) {
        return empty(trim($value));
    }
    return empty($value);
}

# Là betterEmpty() nhưng số nhiều (ít nhất 1 rỗng = true)
function betterEmpty_list(object|array $list): bool
{
    if (betterEmpty($list)) {
        return true;
    } else {
        foreach ($list as $value) {
            if (betterEmpty($value)) {
                return true;
            }
        }
    }
    return false;
}

# Hàm chuyển toàn bộ dữ liệu mix thành StdClass (lớp giả)
function betterStd($mixList)
{
    if (is_array($mixList)) {
        $object = new stdClass();
        foreach ($mixList as $key => $value) {
            $object->$key = betterStd($value);
        }
        return $object;
    } elseif (is_object($mixList)) {
        foreach ($mixList as $key => $value) {
            $mixList->$key = betterStd($value);
        }
        return $mixList;
    } else {
        return $mixList;
    }
}

# Hàm lấy đường dẫn để include trong plugin tốt hơn, có thể lùi đường dẫn
function betterPath($fromDir = __FILE__, $backwardDir = 0, $type = 'wp_include')
{
    # $backwardDir là số lần lùi đường dẫn, mặc định không lùi
    switch ($type) {
        case 'wp_include':
            # Loại bỏ slash back thừa
            $path = rtrim(plugin_dir_path($fromDir), '/');
            # Số lần lùi đường link nếu có
            while ($backwardDir-- > 0) {
                $path = dirname($path);
            }
            # Dán lại slash back
            return $path . '/';
        case 'wp_url':
            # url chưa cập nhật chức năng lùi đường dẫn
            return plugin_dir_url($fromDir);
        default:
            return null;
    }
}

# Hàm chuyển chuỗi thành mảng với str tách tốt hơn
function betterExplode($string, $seprate = ','): array
{
    return explode($seprate, str_replace(' ', '', $string));
}

# Hàm debug tốt hơn, giúp ngăn chạy lệnh kế tiếp, nhẹ nhanh hơn
function betterDebug($value = 'exit only')
{
    var_dump($value);
    exit;
}

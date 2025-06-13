<?php

namespace Model;

use GuzzleHttp\Exception\GuzzleException;
use Helper\Tool;
use Repository\ApiClient;
use RuntimeException;

class Contact extends ApiClient
{
    public function __construct()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());
    }

    // Get
    public function contactList()
    {
        $endpoint = "contact";
        $response = $this->call($endpoint, 'get');
        return $response;
    }

    // CRUD
    public function createNew($postFormParams)
    {
        $contactInfoParams = $this->postFormParamConverter($postFormParams);
        $endpoint = "contact";
        $response = $this->call($endpoint, 'post', $contactInfoParams);

        if (!isset($response->contact_id)) {
            $data = $this->responseStringConverter($response);
        } else {
            $data = [$response];
        }

        return $data;
    }

    // Wrapper
    private function postFormParamConverter($postFormParams)
    {
        return [
            'json' => [
                "gender" => $postFormParams['customerGender'] ?? null,
                "firstname" => $postFormParams['customerFirstname'] ?? null,
                "phonenumber" => $postFormParams['customerPhone'] ?? null, // Gửi thông báo qua zalo
                "nationalid" => $postFormParams['customerNationalId'] ?? null, //Value pattern: ^\d{8,12}$
                "email" => $postFormParams['customerEmail'] ?? null, // Đúng định dạng email
                "birthday" => $postFormParams['customerBirthday'] ?? null, // định dạng dd/mm/yyyy
                "country" => $postFormParams['customerCountry'] ?? null, //Nhập bình thường
                "state" => $postFormParams['customerState'] ?? null, // VN không có bang -> Tỉnh/thành phố
                "city" => $postFormParams['customerDistrict'] ?? null, // Vì state là tỉnh/thành phố nên city biến thành district,  -> Quận/huyện
                "ward" => $postFormParams['customerWard'] ?? null, // Phường/xã
                "address1" => $postFormParams['customerAddress'] ?? null,
                "emailvat" => $postFormParams['customerEmailVat'] ?? null, // Email nhận hoá đơn (nên owner hay admin ta?)
                "type" => "Private", // or Company
                "lastname" => "A", // or Company
                // "password" => "passwordValue",
                // "privileges" => "privilegesValue",
                // "companyname" => "companynameValue",
                // "taxid" => "taxidValue",
                // "source" => "sourceValue",
                // "householdsid" => "householdsidValue" // Mã hộ kinh doanh
            ]
        ];
    }
    private function responseStringConverter($responseStringResponse)
    {
        $store = [];
        foreach ($responseStringResponse->error as $error) {
            if (is_array($error)) {
                foreach ($error as $item) {
                    if ($item !== "field_marked_required") {
                        $store[] = str_replace(' ', '_', strtolower(rtrim($item, "_error"))) . "_required";
                    }
                }
            } else {
                $store[] = rtrim(rtrim($error,  "error"), "_");
            }
        }
        $store = Tool::oopstd($store);
        $data = [];
        foreach ($store as $value) {
            // Bước 1: thay thế kí tự tiếng việt (nếu có)
            $str = mb_strtolower($value, 'UTF-8');
            $replacementStr = ['a', 'e', 'i', 'o', 'u', 'y', 'd'];
            $str = preg_replace([
                '/[áàảãạăắằẳẵặâấầẩẫậ]/u',
                '/[éèẻẽẹêếềểễệ]/u',
                '/[íìỉĩị]/u',
                '/[óòỏõọôốồổỗộơớờởỡợ]/u',
                '/[úùủũụưứừửữự]/u',
                '/[ýỳỷỹỵ]/u',
                '/[đ]/u'
            ], $replacementStr, $str);

            // Bước 2: Xóa ký tự không phải chữ/số/khoảng trắng
            $str = preg_replace('/[^a-z0-9\s_]/', '_', $str);
            $data[] = $str;
        }
        return $data;
    }
}

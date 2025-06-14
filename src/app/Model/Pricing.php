<?php

namespace Model;

use Helper\Maker;
use Repository\ApiClient;
use RuntimeException;

class Pricing extends ApiClient
{
    use Maker;
    private $sslVerify;
    function __construct()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());
    }

    public function fetchAll()
    {
        try {
            $endpoint = "cart/domain/tlds";
            $response = $this->call($endpoint, 'get');
            return $response;
        } catch (\Throwable $e) {
            throw new RuntimeException("Tld pricing in error");
        }
    }

    /**
     * Kéo dữ liệu cho bảng (iframe -> kéo trực tiếp vào view)
     * 
     * @return mixed Dữ liệu kéo cho view
     */
    public function getTable()
    {
        // Không kéo dữ liệu về controller, mà kéo trực tiếp về view, 
        // Vì đây là trường hợp dùng iframe, data cần gửi trực tiếp tới resource view
        $list = [];
        foreach ($this->fetchAll()->tlds as $value) {
            $price = (int) $value->periods[0]->register;
            if ($price < 300000) {
                $domain_type = 'cheap';
            } elseif ($price <= 500000) {
                $domain_type = 'medium';
            } else {
                $domain_type = 'expensive';
            }
            $list[] = std([
                "price_raw" => $price,
                "domain_type" => $domain_type,
                'tld' => $value->tld,
                'price' => number_format(ceil($price), 0, ',', '.') . ' đ',
            ]);
        };
        return [
            "list" => $list,
            "row_height" => CONFIG_TABLE_HEIGHT
        ];
    }
}

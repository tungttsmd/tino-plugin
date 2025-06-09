<?php

namespace Model;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class Domain extends ApiClient
{
    private $searchList;
    private $myDomainCart;
    private $orderList;
    private $domainNameChain;

    // Constructor
    public function __construct($accessToken)
    {
        # Class dược phép sử dụng chain method: $this->domainName("abc.com")->refresh()->search()->getId()
        parent::__construct($accessToken);
        Session::make(); // Class có dùng $_SESSION -> khởi tạo
        $this->searchList = $this->loadSearchListFromSession();
        $this->orderList = $this->loadOrderListFromSession();
        $this->myDomainCart = $this->loadCartListFromSession();
        $this->domainNameChain = ""; // Dùng cho chain method
    }

    // Init 
    public function loadSearchListFromSession()
    {
        return $_SESSION['tino_search_list'] ?? [];
    }
    public function loadCartListFromSession()
    {
        return $_SESSION['tino_cart_list'] ?? [];
    }
    public function loadOrderListFromSession()
    {
        return $_SESSION['tino_order_list'] ?? [];
    }

    // Get
    public function lookup(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = strtolower($domainName);
            return $this->search($domainName)->searchList[$domainName];
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or domain name is not exist in domain lis searched");
        }
    }
    public function getTldPrice(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = strtolower($domainName);
            return $this->search($domainName)->searchList[$domainName]->periods[0]->register;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/register");
        }
    }
    public function getTldId(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = strtolower($domainName);
            return $this->search($domainName)->searchList[$domainName]->tld_id;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/tld_id");
        }
    }

    public function getOrders()
    {
        try {
            return $this->orders()->orderList;
        } catch (\Throwable $e) {
            throw new RuntimeException("Order list data in some errors");
        }
    }
    public function getOrderIds(): array
    {
        try {
            $orderIds = array_map(
                function ($item) {
                    return $item->id;
                },
                $this->getOrders()
            );
            return $orderIds;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/tld_id");
        }
    }
    public function getOrderByName(string $domainName)
    {
        $domainName = strtolower($domainName);
        foreach ($this->getOrders() as $orderItem) {
            if ($orderItem->name === $domainName) {
                return $orderItem;
            };
        }
        return new \stdClass();
    }
    public function getOrderIdByName(string $domainName)
    {
        $domainName = strtolower($domainName);
        $response = $this->getOrderByName($domainName);
        if ((array) $response) {
            return $response->id;
        }
        return "000000";
    }

    // Set
    public function domainName(string $domainName)
    {
        $domainName = strtolower($domainName);
        $lookup = $this->lookup($domainName);
        $this->domainNameChain = $lookup->name;
        return $this;
    }
    public function refresh(string|null $domainName = null)
    {
        // Trường hợp muốn xóa một kết quả để cập nhật lại
        $domainName = strtolower($domainName);
        $domainName = $domainName ?? $this->domainNameChain;
        unset($_SESSION['tino_search_list'][$domainName]);
        unset($this->searchList[$domainName]);
        return $this;
    }
    public function refreshAll()
    {
        // Trường hợp muốn xóa toàn bộ kết quả domain đã tra cứu
        $_SESSION['tino_search_list'] = [];
        $this->searchList = [];
        return $this;
    }
    public function refreshCart()
    {
        // Trường hợp muốn cập nhật lại cart, thì phải làm mới lại
        $_SESSION['tino_cart_list'] = [];
        $this->searchList = [];
        return $this;
    }
    public function refreshOrderList()
    {
        // Trường hợp muốn cập nhật lại order list, thì phải làm mới lại
        $_SESSION['tino_order_list'] = [];
        $this->orderList = [];
        return $this;
    }
    public function search(string|null $domainName = null)
    {
        try {
            // A. Condition
            $domainName = $domainName ?? $this->domainNameChain;
            if (!$domainName) {
                throw new RuntimeException("Domain name is not valid to set.");
            }
            $domainName = strtolower($domainName);

            // Check if expired
            $isExpired = isset($_SESSION['tino_search_list_expired_time']) &&
                (time() > $_SESSION['tino_search_list_expired_time']);

            if ($isExpired) {
                unset($_SESSION['tino_search_list']);
                unset($_SESSION['tino_search_list_expired_time']);
            }

            // Check if already searched
            $hasSession = isset($_SESSION['tino_search_list'][$domainName]);

            if (!$hasSession) {
                // Call API
                $endpoint = "domain/lookup";
                $response = $this->call($endpoint, "post", [
                    'json' => [
                        "name" => $domainName
                    ]
                ]);
                $this->searchList[$domainName] = $response;
                $_SESSION['tino_search_list'][$domainName] = $response;
                $_SESSION['tino_search_list_expired_time'] = time() + 5 * 60;
            } else {
                // Restore from session
                $this->searchList[$domainName] = $_SESSION['tino_search_list'][$domainName];
            }

            return $this;
        } catch (GuzzleException $e) {
            throw new RuntimeException('Domain search failed: ' . $e->getMessage());
        }
    }

    public function orders()
    {
        try {
            // A. Condition
            $flag = true;
            if ($flag && (isset($_SESSION['tino_order_list_expired_time']) && (time() > $_SESSION['tino_order_list_expired_time']))) {
                $flag = false;
                unset($_SESSION['tino_order_list']); // Order list hết hạn rồi
                unset($_SESSION['tino_order_list_expired_time']);
            }

            if (isset($_SESSION['tino_order_list']) && !empty($_SESSION['tino_order_list'])) {
                $flag = false;  // đã có session thì không gọi API
            }

            if ($flag) {
                $endpoint = "domains";
                $response = $this->call($endpoint, "get");
                $this->orderList = $response->domains;
                $_SESSION['tino_order_list'] = $response->domains;
                $_SESSION['tino_order_list_expired_time'] = time() + 5 * 60;
            }
            return $this;
        } catch (GuzzleException $e) {
            // Ném lỗi trong quá trình lấy danh sách domain trong giỏ hàng của tài khoản
            throw new RuntimeException('Domain data invalid or missing periods/tld_id: ' . $e->getMessage());
        }
    }

    // CRUD
    public function domainInspect(string $domainName)
    {
        $domainLookup = $this->lookup(strtolower($domainName));
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        $invoice = new Invoice($auth->token());

        if (isset($domainLookup->error)) {
            // 1. Nếu domain không hợp lệ
            $_SESSION['tino_inspect_save'] = [
                'session_name'     => 'tino_inspect_save',
                'is_in_my_cart'    => false,
                'invoice_id'       => null,
                'order_id'         => null,
                'total_price'      => null,
                'domain_name'      => null,
                'tld_id'           => null,
                'status'           => null,
                'payment_status'   => null,
                'order_time'       => time(),
            ];
            return $_SESSION['tino_inspect_save'];
        }

        // Phản hồi API tino về kiểm tra my cart order thường hay bị lỗi, phải kiểm tra ở phía ngoài lần để khắc phục
        $isInMyCart = $this->getOrderByName($domainLookup->name);

        if (!empty(get_object_vars($isInMyCart))) {
            // 2. Nếu domain đã trong giỏ hàng
            $invoiceDetail = $invoice->getInvoiceByOrderId($isInMyCart->id);
            $_SESSION['tino_inspect_save'] = [
                'session_name'     => 'tino_inspect_save',
                'is_in_my_cart'    => true,
                'invoice_id'       => $invoiceDetail->id,
                'order_id'         => $isInMyCart->id,
                'total_price'      => $invoiceDetail->total,
                'domain_name'      => $domainLookup->name,
                'tld_id'           => $domainLookup->tld_id,
                'status'           => $domainLookup->status,
                'payment_status'   => $invoiceDetail->status,
                'order_time'       => time(),
            ];
        } else {
            // 3. Không trong giỏ hàng -> Kiểm tra trạng thái
            $_SESSION['tino_inspect_save'] = [
                'session_name'      => 'tino_inspect_save',
                'is_in_my_cart'     => false,
                'invoice_id'        => null,
                'order_id'          => null,
                'total_price'       => $domainLookup->periods[0]->register ?? null,
                'domain_name'       => $domainLookup->name ?? null,
                'tld_id'            => $domainLookup->tld_id ?? null,
                'status'            => $domainLookup->status ?? null,
                'payment_status'    => null,
                'order_time'        => time(),
            ];
        }
        return $_SESSION['tino_inspect_save'];
    }
    public function toOrder(string $domainName, array|object $nameservers)
    {
        // Lưu ý $domainName phải là một biến sạch, tức đã trải qua lookup rồi từ lookup->name (dùng set này để đảm bảo sạch)
        $domainLookup = $this->lookup(strtolower($domainName));
        $endpoint = "domain/order";
        $options  = [
            'json' => [
                'name' => $domainLookup->name,
                'years' => "1",
                'action' => 'register',
                'tld_id' =>  $domainLookup->tld_id,
                'pay_method' => '70',
                'nameservers' => (array) $nameservers,
            ],
        ];
        try {
            $response = $this->call($endpoint, "post", $options);
            if (!isset($response->error)) {
                $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
                $invoice = new Invoice($auth->token());
                // API Tino thường sẽ tạo trễ invoice này.
                $invoiceDetail = $invoice->getInvoiceById($response->invoice_id);
                $_SESSION['tino_to_order_save'] = [
                    'session_name'      => 'tino_to_order_save',
                    'is_in_my_cart'     => true,
                    'invoice_id'        => $response->invoice_id,
                    'order_id'          => $response->items[0]->id,
                    'total_price'       => $response->total,
                    'domain_name'       => $response->items[0]->name,
                    'tld_id'            => $response->items[0]->product_id,
                    'status'            => $domainLookup->status,
                    'payment_status'    => $invoiceDetail->status ?? 'unknown',
                    'order_time'        => time(),
                ];
            }

            if (!isset($_SESSION['tino_to_order_save'])) {
                $_SESSION['tino_to_order_save'] = array_merge($this->domainInspect($domainLookup->name), ['session_name' => 'tino_to_order_save']);
            }
            return $_SESSION['tino_to_order_save'];
        } catch (GuzzleException $e) {
            // Ném lỗi trong quá trình lấy danh sách domain trong giỏ hàng của tài khoản
            throw new RuntimeException('Domain data invalid or missing periods/tld_id: ' . $e->getMessage());
        }
    }
}

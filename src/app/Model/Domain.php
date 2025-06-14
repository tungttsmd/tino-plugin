<?php

namespace Model;

use GuzzleHttp\Exception\GuzzleException;
use Helper\Maker;
use Helper\Session;
use Helper\Tool;
use Repository\ApiClient;
use RuntimeException;

class Domain extends ApiClient
{
    use Maker;
    private $searchList;
    private $orderList;
    private $domainNameChain;
    private $invoiceModel;
    private $codePack;

    // Constructor
    public function __construct()
    {
        # Class dược phép sử dụng chain method: $this->domainName("abc.com")->refresh()->search()->getId()
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());

        Session::make(); // Class có dùng $_SESSION -> khởi tạo
        $this->searchList = $this->loadSearchListFromSession();
        $this->codePack = $this->loadCodePack();
        $this->orderList = new \stdClass;
        $this->domainNameChain = ""; // Dùng cho chain method
        $this->invoiceModel = new Invoice();
    }

    // Init 
    public function loadCodePack()
    {
        /* Code:
        * - 100: Domain không nằm trong giỏ hàng + chưa ai sở hữu (lookup status: ok)
        * - 110: Domain không nằm trong giỏ hàng + đã có người sở hữu (lookup status: not ok)
        * - 200: Domain đã nằm trong giỏ hàng + chưa ai sở hữu (lookup status: ok)
        * - 220: Domain đã được đặt hàng thành công
        * - 300: Domain nhập vào không hợp lệ - Đã để trống
        * - 301: Domain nhập vào không hợp lệ - Đuôi tld không hỗ trợ hoặc vấn đề khác
        */

        return [
            '_100' => ['code' => 100, 'color' => 'success', 'alert' => 'Bạn có thể tiến hành đặt hàng tên miền này.'],
            '_110' => ['code' => 110, 'color' => 'warning', 'alert' => 'Tên miền này đã có người sở hữu, vui lòng chọn tên khác.'],
            '_200' => ['code' => 200, 'color' => 'warning', 'alert' => 'Tên miền này hiện tại hệ thống đang xử lý thanh toán, tạm thời không khả dụng'],
            '_220' => ['code' => 220, 'color' => 'success', 'alert' => 'Bạn đã đặt hàng thành công tên miền! Đang chờ thanh toán...'],
            '_300' => ['code' => 300, 'color' => 'danger', 'alert' => 'Bạn chưa nhập tên miền.'],
            '_301' => ['code' => 301, 'color' => 'danger', 'alert' => 'Tên miền không hợp lệ hoặc đuôi tên miền không được hỗ trợ, vui lòng chọn tên miền khác (có đuôi như .vn, .com, .ai...)'],
        ];
    }
    public function loadSearchListFromSession()
    {
        return $_SESSION['tino_search_list'] ?? [];
    }
    public function loadCartListFromSession()
    {
        return $_SESSION['tino_cart_list'] ?? [];
    }

    // Get
    public function lookup(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = trim(strtolower($domainName));
            return $this->search($domainName)->searchList[$domainName];
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or domain name is not exist in domain lis searched");
        }
    }
    public function getTldPrice(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = trim(strtolower($domainName));
            return $this->search($domainName)->searchList[$domainName]->periods[0]->register;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/register");
        }
    }
    public function getTldId(string|null $domainName = null)
    {
        try {
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = trim(strtolower($domainName));
            return $this->search($domainName)->searchList[$domainName]->tld_id;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/tld_id");
        }
    }

    public function getOrders()
    {
        try {
            return $this->orderlist()->orderList;
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
                (array) $this->getOrders()
            );
            return $orderIds;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or missing periods/tld_id");
        }
    }
    public function getOrderByName(string $domainName)
    {
        $domainName = trim(strtolower($domainName));
        foreach ($this->getOrders() as $orderItem) {
            if ($orderItem->name === $domainName) {
                return $orderItem;
            };
        }
        return new \stdClass();
    }
    public function getOrderIdByName(string $domainName)
    {
        $domainName = trim(strtolower($domainName));
        $response = $this->getOrderByName($domainName);
        if (isset($response->id)) {
            return $response->id;
        }
        return "000000";
    }

    // Set
    public function search(string|null $domainName = null)
    {
        try {
            // A. Condition
            $domainName = $domainName ?? $this->domainNameChain;
            $domainName = trim(strtolower($domainName));
            if (!$domainName) {
                throw new RuntimeException("Domain name is not valid to set.");
            }
            $domainName = trim(strtolower($domainName));

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
    public function orderlist()
    {
        try {
            // A. Condition
            $endpoint = "domains";
            $response = $this->call($endpoint, "get");
            $this->orderList = $response->domains;
            return $this;
        } catch (GuzzleException $e) {
            // Ném lỗi trong quá trình lấy danh sách domain trong giỏ hàng của tài khoản
            throw new RuntimeException('Domain data invalid or missing periods/tld_id: ' . $e->getMessage());
        }
    }

    // CRUD
    /**
     * Summary of domainInspect
     * @param string $domainName
     * @return array|mixed
     * Case:
     * - 1 domain is no valid
     *  + just use api tino domain lookup and get ...->error to return an null result
     * - 2 in our cart
     *  + use api call to get invoice detail
     * - 3 not in our cart
     *  + just use api tino domain lookup
     * 
     */
    public function domainInspect(string $domainName)
    {
        $codePack = $this->codePack;
        extract($codePack);

        if (!isset($domainName) || empty($domainName)) {
            // 0. Ngừa lỗi nội bộ không nhập domainName
            $_SESSION['tino_inspect_save'] = [
                'session_name'     => 'tino_inspect_save',
                'is_in_my_cart'    => false,
                'invoice_id'       => null,
                'order_id'         => null,
                'total_price'      => null,
                'domain_name'      => trim(strtolower($domainName)),
                'tld_id'           => null,
                'status'           => null,
                'payment_status'   => null,
                'order_time'       => time(),
                'info'      => [
                    'alert' => empty(trim(strtolower($domainName))) ? $_300['alert'] : $_301['alert'],
                    'color' => empty(trim(strtolower($domainName))) ? $_300['color'] : $_301['color'],
                    'code' => empty(trim(strtolower($domainName))) ? $_300['code'] : $_301['code'],
                    'message' => 'Domain inspect: Domain input is not valid, please check again.',
                ],
            ];
            return $_SESSION['tino_inspect_save'];
        }

        $domainLookup = $this->lookup(trim(strtolower($domainName)));

        if (isset($domainLookup->error)) {
            // 1. Nếu lookup tìm name domain không hợp lệ
            $_SESSION['tino_inspect_save'] = [
                'session_name'     => 'tino_inspect_save',
                'is_in_my_cart'    => false,
                'invoice_id'       => null,
                'order_id'         => null,
                'total_price'      => null,
                'domain_name'      => trim(strtolower($domainName)),
                'tld_id'           => null,
                'status'           => null,
                'payment_status'   => null,
                'order_time'       => time(),
                'info' => [
                    'alert' => $_301['alert'],
                    'color' => $_301['color'],
                    'code' => $_301['code'],
                    'message' => 'Domain inspect: Domain input is not valid, please check again.'

                ]

            ];
            return $_SESSION['tino_inspect_save'];
        }

        // Phản hồi API tino về kiểm tra my cart order thường hay bị lỗi, phải kiểm tra ở phía ngoài lần để khắc phục
        $isInMyCart = $this->getOrderByName($domainLookup->name);
        if (!empty(get_object_vars($isInMyCart))) {
            // 2. Nếu domain đã trong giỏ hàng
            $invoiceDetail = $this->invoiceModel->fetchInvoiceByOrderId($isInMyCart->id);
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
                'info' => [
                    'alert' => $_200['alert'],
                    'color' => $_200['color'],
                    'code' => $_200['code'],
                    'message' => 'Domain inspect: This domain is in our cart! Return is domain order invoice information.'
                ]
            ];
        } else {
            $totalPrice = $domainLookup->tld_id === "567" ? 450000 : $domainLookup->periods[0]->register;
            // 3. Không trong giỏ hàng -> Kiểm tra trạng thái
            $_SESSION['tino_inspect_save'] = [
                'session_name'      => 'tino_inspect_save',
                'is_in_my_cart'     => false,
                'invoice_id'        => null,
                'order_id'          => null,
                'total_price'       => $totalPrice,
                'domain_name'       => $domainLookup->name,
                'tld_id'            => $domainLookup->tld_id,
                'status'            => $domainLookup->status,
                'payment_status'    => null,
                'order_time'        => time(),
                'info' => [
                    'alert' => $domainLookup->status === "ok" ? 'Tên miền: <b><i>' . $domainLookup->name . '</i></b> Tổng tiền: <b><u>' . number_format($totalPrice, 0, ',', '.') . '</u></b> đ . ' . $_100['alert'] : $_110['alert'],
                    'color' => $domainLookup->status === "ok" ? $_100['color'] : $_110['color'],
                    'code'  => $domainLookup->status === "ok" ? $_100['code'] : $_110['code'],
                    'message' => 'Domain inspect: This domain is not in our cart! Return is domain lookup information.'
                ],
                '_100_status_anti_csrf'  => [
                    'domain_name' => $domainLookup->status === "ok" ? $_SESSION['_100_status_anti_csrf_domain_name'] = $domainLookup->name : false,
                    'domain_total' => number_format($totalPrice, 0, ',', '.')
                ]
            ];
        }
        return $_SESSION['tino_inspect_save'];
    }

    /**
     * Summary of toOrder
     * @param string $domainName
     * @param array|object $nameservers
     * @throws \RuntimeException
     * @return array|mixed
     * 
     * reuse domainInspect() if return have key status = ok, order it.
     * Case:
     * - status ok available and not in my cart to order
     *  + run order, if error -> catch guzzle exception
     * - status ok available and in my cart
     *  + convert to inspect mode, return as domainInspect() + message of ORDER ERROR
     * - status not ok
     *  + convert to inspect mode, return as domainInspect() + message of ORDER ERROR
     */
    public function domainToOrder(string $domainName, string|int|float|null $contactAccessId = null, array|object|null $nameservers = null)
    {
        $codePack = $this->codePack;
        extract($codePack);

        if (!isset($domainName) || empty($domainName)) {
            // 0. Ngừa lỗi nội bộ không nhập domainName
            $_SESSION['tino_inspect_save'] = [
                'session_name'     => 'tino_inspect_save',
                'is_in_my_cart'    => false,
                'invoice_id'       => null,
                'order_id'         => null,
                'total_price'      => null,
                'domain_name'      => trim(strtolower($domainName)),
                'tld_id'           => null,
                'status'           => null,
                'payment_status'   => null,
                'order_time'       => time(),
                'info'      => [
                    'alert' => empty(trim(strtolower($domainName))) ? $_300['alert'] : $_301['alert'],
                    'color' => empty(trim(strtolower($domainName))) ? $_300['color'] : $_301['color'],
                    'code' => empty(trim(strtolower($domainName))) ? $_300['code'] : $_301['code'],
                    'message' => 'Domain inspect: Domain input is not valid, please check again.',
                ],
                'order_error' => 'ORDER ERROR: Ordered failed, EMPTY DOMAIN INPUT?'
            ];
        }

        // Lưu ý $domainName phải là một biến sạch, tức đã trải qua lookup rồi từ lookup->name (dùng set này để đảm bảo sạch)
        $domainInspect = $this->domainInspect(trim(strtolower($domainName)));

        if (isset($domainInspect['status'], $domainInspect['is_in_my_cart']) && $domainInspect['status'] === "ok" && $domainInspect['is_in_my_cart'] === false) {

            $options  = [
                'json' => [
                    'name' => $domainInspect['domain_name'],
                    'years' => "1",
                    'action' => 'register',
                    'tld_id' =>  $domainInspect['tld_id'],
                    'pay_method' => '70',
                    'nameservers' => (array) $nameservers ?? [],
                    // "admin" => "adminValue",
                    // "tech" => "techValue",
                    // "billing" => "billingValue",
                ],
            ];
            // Client contact là chủ sở hữu tên miền và xác thực theo đó, parent là chủ tài khoản đăng nhập my.tino.vn để mua hộ tên miền
            $clientContactId = Tool::make()->oopstd(Contact::make()->getClientIdByAccessId($contactAccessId));
            $parentContactId = Tool::make()->oopstd(mixList: Contact::make()->getLoggedInContactId());
            if ($contactAccessId) {
                // Nếu người dùng điền đầy đủ thông tin
                $options['json']['registrant'] = (int) $clientContactId;  // Chủ thể sở hữu tên miền (người thực hiện mua)
                $options['json']['admin'] = (int) $clientContactId;   // Chủ thể sở hữu tên miền tự quản lý tên miền (người thực hiện mua)
                $options['json']['billing'] = (int) $clientContactId;   // Thông tin hoá đơn theo chủ thể sở hữu (người thực hiện mua)
                $options['json']['tech'] = (int) $parentContactId;  // Chủ tài khoản my.tino.vn được phép hỗ trợ kỹ thuật (quyền admin domain) (người mua hộ)
            };
            try {
                $endpoint = "domain/order";
                $response = $this->call($endpoint, "post", $options);
                if (!isset($response->error)) {
                    // API Tino thường sẽ tạo trễ invoice sau khi mới order này.
                    $invoiceDetail = $this->invoiceModel->getInvoiceById($response->invoice_id);
                    $_SESSION['tino_to_order_save'] = [
                        'session_name'      => 'tino_to_order_save',
                        'is_in_my_cart'     => true,
                        'invoice_id'        => $response->invoice_id,
                        'order_id'          => $response->items[0]->id,
                        'total_price'       => $response->total,
                        'domain_name'       => $response->items[0]->name,
                        'tld_id'            => $response->items[0]->product_id,
                        'status'            => $domainInspect['status'],
                        'payment_status'    => $invoiceDetail->status ?? null,
                        'order_time'        => time(),
                        'info'      => [
                            'alert' => $_220['alert'],
                            'color' => $_220['color'],
                            'code' => $_220['code'],
                            'message' => 'Domain inspect: Domain input is not valid, please check again.',
                        ],
                        'order_error'      => 'Ordered successfully! Return is the ordered information'
                    ];
                } else {
                    // Trường hợp order không thành công (do status không ok) nên chuyển sang lookup để kiểm tra nội dung gì
                    return array_merge($domainInspect, [
                        'order_error' => 'ORDER ERROR: ' . $response->error[0] . ' - Ordered failed! Converted Domain Inspect mode: Return is the domain lookup information'
                    ]);
                }

                // debug backup = $_SESSION['tino_to_order_save'] only
                return array_merge($_SESSION['tino_to_order_save'], ['orderInfo' => $this->fetchOrderById($_SESSION['tino_to_order_save']['order_id'])]);
            } catch (GuzzleException $e) {
                // Ném lỗi trong quá trình lấy danh sách domain trong giỏ hàng của tài khoản
                throw new RuntimeException('Domain data invalid or missing periods/tld_id: ' . $e->getMessage());
            }
        } else {
            // Nếu domain không available để đặt hàng hoặc đã được hệ thống đặt hàng từ trước, thì lấy kết quả của inspect để trả về
            return array_merge($domainInspect, [
                '   '      => 'ORDER ERROR: status = ' . $domainInspect['status'] . ' - Ordered failed, this domain is not available to order or ordered before! Converted Domain Inspect mode: Return is the domain lookup information'
            ]);
        }
    }
}

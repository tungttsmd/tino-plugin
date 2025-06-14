<?php

namespace Controller;

use Action\RenderAction;
use Service\OrderService;
use Helper\Maker;
use Helper\Tool;
use Model\Contact;
use Model\Domain;
use Model\Order;
use Repository\ApiClient;
use Service\ContactService;
use stdClass;

class SyncController
{
    use Maker;

    public function panel()
    {
        $tool = Tool::make();

        if (isset($_GET['tab'])) {
            if ($_GET['tab'] === "contact") {
                if (isset($_GET['detail'])) {
                    $getData = $tool->oopstd(Contact::make()->fetchContactDetail($_GET['detail']));
                    $data = $getData->contact;
                    $data->client_id = $tool->oopstd(Contact::make()->getClientIdByAccessId($data->id));
                    echo RenderAction::make()->contactDetailRender($data);
                } else {
                    $getData = $tool->oopstd(Contact::make()->fetchContactList());
                    $data = $getData->contacts;
                    echo RenderAction::make()->contactListRender($data);
                }
            } elseif ($_GET['tab'] === "order") {
                if (isset($_GET['detail'])) {
                    $getData = $tool->oopstd(Order::make()->fetchOrderDetail($_GET['detail']));
                    $getContact = $tool->oopstd(Order::make()->getOrderContactById($_GET['detail']));
                    $getTotal = $tool->oopstd(Domain::make()->lookup($getData->details->name));
                    $data = $tool->oopstd([
                        "order_id" => $getData->details->id,
                        "payment" => $getData->details->status,
                        "order_date" => $getData->details->date_created,
                        "domain_name" => $getData->details->name,
                        "domain_price" => $getTotal->tld === ".vn" ? "450000" : $getTotal->periods->{'0'}->register,
                        "nameservers" => $getData->details->nameservers,
                        "contact" => $getContact->contact_info,
                        "ekyc_info" => $getData->details->ddocs,
                    ]);
                    echo RenderAction::make()->orderDetailRender($data);
                } else {
                    $data = new stdClass;
                    $getData = $tool->oopstd(Order::make()->fetchOrderList());
                    foreach ($getData->domains as $key => $item) {
                        $data->{$key} = $item;
                        $data->{$key}->tld = substr($item->name, strpos($item->name, "."));
                    };
                    echo RenderAction::make()->orderListRender($data);
                }
            } else {
                echo "Vui lòng nhập đúng panel tab";
            }
            exit; // Không cần tải thêm
        } else {
            echo RenderAction::make()->layoutRender();
        }
    }
}

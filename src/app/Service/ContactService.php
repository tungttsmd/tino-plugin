<?php

namespace Service;

use Helper\Maker;
use Model\Contact;

class ContactService
{
    use Maker;
    /**
     * Kéo dữ liệu contact panel
     * 
     * @return mixed HTML Contact Panel
     */
    public function contactPanel($request = null)
    {
        if ($request !== null) {
            $getData = std(Contact::make()->fetchContactDetail($request));
            $data = $getData->contact;
            $data->client_id = Contact::make()->getClientIdByAccessId($data->id);
            return $data;
        }
        $getData = std(Contact::make()->fetchContactList());
        $data = $getData->contacts;
        return $data;
    }
}

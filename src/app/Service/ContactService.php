<?php

namespace Service;

use Helper\Maker;
use Model\Contact;

class ContactService
{
    use Maker;
    private $contactModel;
    public function __construct()
    {
        $this->contactModel = new Contact();
    }

    public function fetchContactList()
    {
        $response = $this->contactModel->fetchContactList();
        return $response;
    }
}

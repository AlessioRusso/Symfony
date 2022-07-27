<?php

namespace App\Services;

use App\Services\OptionalServiceTrait;

class MyService
{
    
    use OptionalServiceTrait;

    public function __construct($param, $adminEmail, $globalParam)
    {
        dump($param);
        dump($adminEmail);
        dump($globalParam);
    }

    public function someAction()
    {
        dump($this->service->doSomething());
    }
}
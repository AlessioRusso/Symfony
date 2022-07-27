<?php 

namespace App\Services;

class MySecondService implements ServiceInterface
{
    public function __construct()
    {
        dump('second service!');
    }

    public function doSomething(){
        return 'wow';
    }
}
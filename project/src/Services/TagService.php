<?php

namespace App\Services;


class TagService
{

    public function __construct()
    {
        dump('tag service');
    }

    public function postFlush()
    {
        dump('post Flush event');
    }

    public function clear()
    {
        dump('clear');
    }
}
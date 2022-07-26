<?php

namespace App\Services;
use Psr\Log\LoggerInterface;

class GiftsService {

    public $gifts = ['car', 'piano', 'money', 'flower'];

    public function __construct(LoggerInterface $logger)
    {
        $logger->info('Gifts were randomized!');
        shuffle($this->gifts);
    }

}
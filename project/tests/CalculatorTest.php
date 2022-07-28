<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Services\Calculator;

class CalculatorTest extends TestCase
{
    public function testSomething()
    {

        $calc = new Calculator();
        $res = $calc->add(3, 4);
        $this->assertEquals($res, 7);
    }
}

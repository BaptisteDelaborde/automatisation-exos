<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class Calculator extends TestCase{

    public function setUp() : void {
        $this->calculator = new Calculator();
    }

    public function testAdd(): void {
        $result = $this->calculator->add(2,3);
        self::assertEquals(5,$results);
    }
} 

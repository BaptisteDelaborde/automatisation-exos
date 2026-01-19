<?php

namespace App\Tests\Entity;

use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase{

    private $wallet1;

    public function setUp(): void {
        $this->wallet1 = new Wallet('EUR');
    }

    public function testConstructor(): void {
        $this->assertSame('EUR', $this->wallet1->getCurrency());
        $this->assertSame(0.0, $this->wallet1->getBalance());
    }

    public function testSetCurrencyAcceptsValidCurrency(): void {
        $wallet = new Wallet('EUR');
        $wallet->setCurrency('USD');
        $this->assertSame('USD', $wallet->getCurrency());
    }

    public function testSetCurrencyThrowsExceptionForInvalidCurrency(): void {
        $this->expectException(\Exception::class);
        $this->wallet1->setCurrency('GBP');
    }


    public function testSetBalanceAcceptsValidBalance(): void {
        $wallet = new Wallet('EUR');
        $wallet->setBalance(100);
        $this->assertSame(100.0, $wallet->getBalance());
    }

    public function testSetBalanceThrowsExceptionForNegativeBalance(): void {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->setBalance(-10);
    }


    public function testAddFundIncreasesBalance(): void {
        $wallet = new Wallet('EUR');
        $wallet->addFund(50);
        $this->assertSame(50.0, $wallet->getBalance());
    }

    public function testAddFundThrowsExceptionForNegativeAmount(): void {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->addFund(-5);
    }

    public function testRemoveFundDecreasesBalance(): void {
        $wallet = new Wallet('EUR');
        $wallet->addFund(100);
        $wallet->removeFund(40);
        $this->assertSame(60.0, $wallet->getBalance());
    }

    public function testRemoveFundThrowsExceptionForNegativeAmount(): void {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->removeFund(-10);
    }

    public function testRemoveFundThrowsExceptionForInsufficientFunds(): void {
        $this->expectException(\Exception::class);
        $wallet = new Wallet('EUR');
        $wallet->addFund(20);
        $wallet->removeFund(50);
    }



}

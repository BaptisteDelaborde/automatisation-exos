<?php

namespace App\Tests\Entity;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase {

    public function testConstructorInitializesName(): void {
        $person = new Person('Burak', 'EUR');
        $this->assertSame('Burak', $person->getName());
    }

    public function testConstructorInitializesWallet(): void {
        $person = new Person('Burak', 'EUR');
        $this->assertInstanceOf(Wallet::class, $person->getWallet());
        $this->assertSame('EUR', $person->getWallet()->getCurrency());
        $this->assertSame(0.0, $person->getWallet()->getBalance());
    }

    public function testSetNameUpdatesName(): void {
        $person = new Person('Burak', 'EUR');
        $person->setName('Arman');
        $this->assertSame('Arman', $person->getName());
    }

    public function testGetWalletReturnsWallet(): void {
        $person = new Person('Burak', 'EUR');
        $this->assertInstanceOf(Wallet::class, $person->getWallet());
    }

    public function testSetWalletReplacesWallet(): void {
        $person = new Person('Arman', 'EUR');
        $wallet = new Wallet('USD');
        $person->setWallet($wallet);
        $this->assertSame($wallet, $person->getWallet());
    }

    public function testHasFundReturnsFalseWhenBalanceIsZero(): void {
        $person = new Person('Arman', 'EUR');
        $this->assertFalse($person->hasFund());
    }

    public function testHasFundReturnsTrueWhenBalanceIsNotZero(): void {
        $person = new Person('Arman', 'EUR');
        $person->getWallet()->addFund(10);
        $this->assertTrue($person->hasFund());
    }

    public function testTransferFundMovesMoneyBetweenPersons(): void {
        $burak = new Person('burak', 'EUR');
        $arman = new Person('arman', 'EUR');
        $burak->getWallet()->addFund(50);
        $burak->transfertFund(20, $arman);
        $this->assertSame(30.0, $burak->getWallet()->getBalance());
        $this->assertSame(20.0, $arman->getWallet()->getBalance());
    }

    public function testTransferFundThrowsExceptionWithDifferentCurrencies(): void {
        $this->expectException(\Exception::class);
        $burak = new Person('burak', 'EUR');
        $arman = new Person('arman', 'USD');
        $burak->transfertFund(10, $arman);
    }

    public function testDivideWalletSplitsBalanceBetweenPersons(): void {
        $owner = new Person('Owner', 'EUR');
        $p1 = new Person('P1', 'EUR');
        $p2 = new Person('P2', 'EUR');
        $owner->getWallet()->addFund(100);
        $owner->divideWallet([$p1, $p2]);
        $this->assertSame(50.0, $p1->getWallet()->getBalance());
        $this->assertSame(50.0, $p2->getWallet()->getBalance());
        $this->assertSame(0.0, $owner->getWallet()->getBalance());
    }

    public function testDivideWalletIgnoresPersonsWithDifferentCurrency(): void {
        $owner = new Person('Owner', 'EUR');
        $eurPerson = new Person('EUR', 'EUR');
        $usdPerson = new Person('USD', 'USD');
        $owner->getWallet()->addFund(40);
        $owner->divideWallet([$eurPerson, $usdPerson]);
        $this->assertSame(40.0, $eurPerson->getWallet()->getBalance());
        $this->assertSame(0.0, $usdPerson->getWallet()->getBalance());
    }

    public function testBuyProductRemovesFunds(): void {
        $person = new Person('burak', 'EUR');
        $product = new Product('Book', ['EUR' => 20.0], 'other');
        $person->getWallet()->addFund(50);
        $person->buyProduct($product);
        $this->assertSame(30.0, $person->getWallet()->getBalance());
    }

    public function testBuyProductThrowsExceptionWhenCurrencyIsNotSupported(): void {
        $this->expectException(\Exception::class);
        $person = new Person('Burak', 'EUR');
        $product = new Product('Book', ['USD' => 20.0], 'other');
        $person->buyProduct($product);
    }


}

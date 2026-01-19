<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {
    public function testConstructorInitializesProperties(): void {
        $product = new Product('Apple', ['EUR' => 2.5, 'USD' => 3.0], 'food');
        $this->assertSame('Apple', $product->getName());
        $this->assertSame('food', $product->getType());
        $this->assertSame(['EUR' => 2.5, 'USD' => 3.0], $product->getPrices());
    }


    public function testSetTypeAcceptsValidType(): void {
        $product = new Product('Phone',['EUR' => 500], 'tech');
        $this->assertSame('tech', $product->getType());
    }

    public function testSetTypeThrowsExceptionForInvalidType(): void {
        $this->expectException(\Exception::class);
        new Product('Unknown',['EUR' => 10], 'invalid_type');
    }


    public function testSetPricesIgnoresInvalidCurrency(): void {
        $product = new Product('Item', ['EUR' => 10, 'GBP' => 20], 'other');
        $this->assertSame(['EUR' => 10], $product->getPrices());
    }

    public function testSetPricesIgnoresNegativePrice(): void {
        $product = new Product('Item', ['EUR' => -10, 'USD' => 5], 'other');
        $this->assertSame(['USD' => 5], $product->getPrices());
    }


    public function testGetTVAReturnsTenPercentForFood(): void {
        $product = new Product('Bread', ['EUR' => 1],'food');
        $this->assertSame(0.1, $product->getTVA());
    }

    public function testGetTVAReturnsTwentyPercentForOtherProducts(): void {
        $product = new Product('Phone', ['EUR' => 500], 'tech');
        $this->assertSame(0.2, $product->getTVA());
    }


    public function testListCurrenciesReturnsAvailableCurrencies(): void {
        $product = new Product('Item', ['EUR' => 10, 'USD' => 15],'other');
        $currencies = $product->listCurrencies();
        $this->assertContains('EUR', $currencies);
        $this->assertContains('USD', $currencies);
        $this->assertCount(2, $currencies);
    }

    public function testGetPriceReturnsCorrectPrice(): void {
        $product = new Product('Item', ['EUR' => 10], 'other');
        $this->assertSame(10.0, $product->getPrice('EUR'));
    }

    public function testGetPriceThrowsExceptionForInvalidCurrency(): void {
        $this->expectException(\Exception::class);
        $product = new Product('Item',['EUR' => 10],'other');
        $product->getPrice('GBP');
    }

    public function testGetPriceThrowsExceptionWhenCurrencyNotAvailable(): void {
        $this->expectException(\Exception::class);
        $product = new Product('Item', ['EUR' => 10], 'other');
        $product->getPrice('USD');
    }

    
}

<?php

namespace Test\Unit\Result;

require_once dirname(dirname(__DIR__)) . '/Setup.php';

use Test\Setup;
use Braintree;

class SuccessfulTest extends Setup
{
    public function testJsonSerializeReturnsSuccessAndReturnObjects()
    {
        $transaction = Braintree\Transaction::factory([
            'id' => 'txn123',
            'amount' => '10.00',
            'status' => 'authorized',
        ]);
        $result = new Braintree\Result\Successful($transaction);

        $json = json_decode(json_encode($result), true);

        $this->assertTrue($json['success']);
        $this->assertEquals('txn123', $json['transaction']['id']);
        $this->assertEquals('10.00', $json['transaction']['amount']);
    }

    public function testJsonSerializeWithMultipleReturnObjects()
    {
        $obj1 = Braintree\Transaction::factory(['id' => 'txn1', 'amount' => '5.00', 'status' => 'authorized']);
        $obj2 = Braintree\Customer::factory(['id' => 'cust1']);
        $result = new Braintree\Result\Successful([$obj1, $obj2], ['transaction', 'customer']);

        $json = json_decode(json_encode($result), true);

        $this->assertTrue($json['success']);
        $this->assertEquals('txn1', $json['transaction']['id']);
        $this->assertEquals('cust1', $json['customer']['id']);
    }

    public function testCallingNonExsitingFieldReturnsNull()
    {
        $this->expectError();
        $this->expectExceptionMessage('Undefined property on Braintree\Result\Successful: notAProperty');

        $result = new Braintree\Result\Successful(1, 'transaction');

        $this->assertNotNull($result->transaction);
        $this->assertNull($result->notAProperty);
    }
}

<?php

namespace Test\Unit;

require_once dirname(__DIR__) . '/Setup.php';

use Test\Setup;
use Braintree;

class ApplePayCardTest extends Setup
{
    public function testBinData()
    {
        $card = Braintree\ApplePayCard::factory(
            [
                'business' => 'No',
                'consumer' => 'Yes',
                'corporate' => 'No',
                'purchase' => 'Yes'
            ]
        );
        $this->assertEquals(Braintree\CreditCard::BUSINESS_NO, $card->business);
        $this->assertEquals(Braintree\CreditCard::CONSUMER_YES, $card->consumer);
        $this->assertEquals(Braintree\CreditCard::CORPORATE_NO, $card->corporate);
        $this->assertEquals(Braintree\CreditCard::PURCHASE_YES, $card->purchase);
    }

    public function testMpanData()
    {
        $card = Braintree\ApplePayCard::factory(
            [
                'isDeviceToken' => false,
                'merchantTokenIdentifier' => 'a-merchant-token-identifier'
            ]
        );
        $this->assertEquals(false, $card->isDeviceToken);
        $this->assertEquals("a-merchant-token-identifier", $card->merchantTokenIdentifier);
    }

    public function testVerificationsSortedByCreatedAt()
    {
        $card = Braintree\ApplePayCard::factory([
            'verifications' => [
                [
                    'id' => 'verification1',
                    'status' => 'verified',
                    'createdAt' => '2023-01-01T10:00:00Z'
                ],
                [
                    'id' => 'verification2',
                    'status' => 'verified',
                    'createdAt' => '2023-01-03T10:00:00Z'
                ],
                [
                    'id' => 'verification3',
                    'status' => 'verified',
                    'createdAt' => '2023-02-02T10:00:00Z'
                ]
            ]
        ]);

        $this->assertEquals('verification3', $card->verification->id);
    }
}

<?php

namespace Test\unit;

require_once dirname(__DIR__) . '/Setup.php';

use Test\Setup;
use Braintree;

class LocalPaymentTest extends Setup
{
    public function testFactory()
    {
        $localPayment = Braintree\LocalPayment::factory([]);
        $this->assertInstanceOf('Braintree\LocalPayment', $localPayment);
    }

    public function testFactoryWithAttributes()
    {
        $attributes = [
            'id' => 'payment_id_123',
            'legacyId' => 'legacy_123',
            'type' => 'MBWAY',
            'paymentId' => 'payment_123',
            'orderId' => 'order_123',
            'approvalUrl' => 'https://example.com/approval',
            'merchantAccountId' => 'merchant_account_123',
            'amount' => [
                'value' => '10.00',
                'currencyCode' => 'EUR'
            ],
            'createdAt' => '2024-01-01T00:00:00Z',
            'updatedAt' => '2024-01-01T00:00:00Z',
            'transactedAt' => '2024-01-01T00:00:00Z',
            'approvedAt' => '2024-01-01T00:00:00Z',
            'expiredAt' => null
        ];

        $localPayment = Braintree\LocalPayment::factory($attributes);

        $this->assertEquals('payment_id_123', $localPayment->id);
        $this->assertEquals('legacy_123', $localPayment->legacyId);
        $this->assertEquals('MBWAY', $localPayment->type);
        $this->assertEquals('payment_123', $localPayment->paymentId);
        $this->assertEquals('order_123', $localPayment->orderId);
        $this->assertEquals('https://example.com/approval', $localPayment->approvalUrl);
        $this->assertEquals('merchant_account_123', $localPayment->merchantAccountId);
        $this->assertEquals('2024-01-01T00:00:00Z', $localPayment->createdAt);
        $this->assertEquals('2024-01-01T00:00:00Z', $localPayment->updatedAt);
        $this->assertEquals('2024-01-01T00:00:00Z', $localPayment->transactedAt);
        $this->assertEquals('2024-01-01T00:00:00Z', $localPayment->approvedAt);
        $this->assertEquals(null, $localPayment->expiredAt);
    }

    public function testAmount()
    {
        $attributes = [
            'amount' => [
                'value' => '10.00',
                'currencyCode' => 'EUR'
            ]
        ];

        $localPayment = Braintree\LocalPayment::factory($attributes);

        $this->assertInstanceOf('Braintree\MonetaryAmount', $localPayment->amount);
        $this->assertEquals('10.00', $localPayment->amount->value);
        $this->assertEquals('EUR', $localPayment->amount->currencyCode);
    }

    public function testApprovalUrl()
    {
        $localPayment = Braintree\LocalPayment::factory(['approvalUrl' => 'https://example.com/approval']);
        $this->assertEquals('https://example.com/approval', $localPayment->approvalUrl);
    }

    public function testId()
    {
        $localPayment = Braintree\LocalPayment::factory(['id' => 'payment_id_123']);
        $this->assertEquals('payment_id_123', $localPayment->id);
    }

    public function testLegacyId()
    {
        $localPayment = Braintree\LocalPayment::factory(['legacyId' => 'legacy_123']);
        $this->assertEquals('legacy_123', $localPayment->legacyId);
    }

    public function testMerchantAccountId()
    {
        $localPayment = Braintree\LocalPayment::factory(['merchantAccountId' => 'merchant_account_123']);
        $this->assertEquals('merchant_account_123', $localPayment->merchantAccountId);
    }

    public function testType()
    {
        $localPayment = Braintree\LocalPayment::factory(['type' => 'MBWAY']);
        $this->assertEquals('MBWAY', $localPayment->type);
    }
}

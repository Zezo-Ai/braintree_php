<?php

namespace Test\Unit;

require_once dirname(__DIR__) . '/Setup.php';

use Test\Setup;
use Braintree;

class MultipleValueNodeTest extends Setup
{
    public function testIs()
    {
        $node = new Braintree\MultipleValueNode('field');
        $node->is('value');
        $this->assertEquals(['value'], $node->toParam());
    }

    public function testIn()
    {
        $node = new Braintree\MultipleValueNode('field');
        $node->in(['firstValue', 'secondValue']);
        $this->assertEquals(['firstValue', 'secondValue'], $node->toParam());
    }

    public function testIn_throwsIfInvalidValueGiven()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Invalid argument(s) for status: invalid_value');
        $node = new Braintree\MultipleValueNode('status', ['active', 'inactive']);
        $node->in(['active', 'invalid_value']);
    }

    public function testIn_allowsAllValuesWhenNoAllowedValuesRestriction()
    {
        $node = new Braintree\MultipleValueNode('ids', []);
        $node->in(['anything', 'goes']);
        $this->assertEquals(['anything', 'goes'], $node->toParam());
    }

    public function testAchType_nodeName()
    {
        $node = Braintree\TransactionSearch::achType();
        $this->assertEquals('ach_type', $node->name);
    }

    public function testAchType_is_sameDay()
    {
        $node = Braintree\TransactionSearch::achType();
        $node->is(Braintree\Transaction::ACH_TYPE_SAME_DAY);
        $this->assertEquals(['same_day'], $node->toParam());
    }

    public function testAchType_is_standard()
    {
        $node = Braintree\TransactionSearch::achType();
        $node->is(Braintree\Transaction::ACH_TYPE_STANDARD);
        $this->assertEquals(['standard'], $node->toParam());
    }

    public function testAchType_in_bothValues()
    {
        $node = Braintree\TransactionSearch::achType();
        $node->in([
            Braintree\Transaction::ACH_TYPE_SAME_DAY,
            Braintree\Transaction::ACH_TYPE_STANDARD
        ]);
        $this->assertEquals(['same_day', 'standard'], $node->toParam());
    }

    public function testAchType_allowedValues()
    {
        $this->expectException('InvalidArgumentException');
        $node = Braintree\TransactionSearch::achType();
        $node->is('noSuchAchType');
    }
}

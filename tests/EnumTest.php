<?php

namespace CorpSoft\Tests\Enum;

use CorpSoft\Enum\BooleanEnum;

class EnumTest extends \PHPUnit\Framework\TestCase
{
    public function testEnumMethods()
    {
        $this->assertEquals(['NO', 'YES'], BooleanEnum::getConstantsByValue());
        $this->assertEquals(['YES' => 1, 'NO' => 0], BooleanEnum::getConstantsByName());
        $this->assertEquals(['No', 'Yes'], BooleanEnum::listData());
        $this->assertEquals('Yes', BooleanEnum::getLabel(BooleanEnum::YES));
        $this->assertEquals(1, BooleanEnum::getValueByName('Yes'));
    }

    public function testValidation()
    {
        $this->assertFalse(BooleanEnum::isValidName(1));
        $this->assertTrue(BooleanEnum::isValidName('YES'));
        $this->assertTrue(BooleanEnum::isValidValue(1));
        $this->assertFalse(BooleanEnum::isValidValue('NOT_VALID'));
    }

    public function testCreateByName()
    {
        $enum = BooleanEnum::createByName('YES');
        $this->assertEquals(BooleanEnum::YES, $enum->getValue());
        $this->assertTrue(array_key_exists($enum->getName(), BooleanEnum::getConstantsByName()));
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testFailedCreateByName()
    {
        BooleanEnum::createByName('not existing name');
    }

    public function testCreateByValue()
    {
        $enum = BooleanEnum::createByValue(BooleanEnum::YES);
        $this->assertEquals(BooleanEnum::YES, $enum->getValue());
        $this->assertTrue(array_key_exists($enum->getName(), BooleanEnum::getConstantsByName()));
    }

    public function testCreateByStaticFunction()
    {
        $enum = BooleanEnum::YES();
        $this->assertEquals(BooleanEnum::YES, $enum->getValue());
        $this->assertTrue(array_key_exists($enum->getName(), BooleanEnum::getConstantsByName()));
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testFailedCreateByValue()
    {
        BooleanEnum::createByValue('not existing value');
    }
}

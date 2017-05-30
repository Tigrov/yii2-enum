<?php

namespace tigrov\tests\unit\enum;

use tigrov\tests\unit\enum\data\GenderCode;
use tigrov\tests\unit\enum\data\Model;

class EnumBehaviorTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockApplication();
    }

    public function testValues()
    {
        $this->assertSame(['M' => 'Male', 'F' => 'Female'], GenderCode::values());
    }

    public function testValue()
    {
        $this->assertSame('Female', GenderCode::value(GenderCode::FEMALE));
    }

    public function testCodes()
    {
        $this->assertSame(['M', 'F'], GenderCode::codes());
    }

    public function testHasProperty()
    {
        $model = new Model;
        $this->assertTrue($model->hasProperty('gender'));
    }

    public function testProperty()
    {
        $model = new Model;
        $model->gender_code = 'M';
        $this->assertSame('Male', $model->gender);
    }

    public function testArray()
    {
        $model = new Model;
        $model->gender_code = ['M', 'F'];
        $this->assertSame(['M' => 'Male', 'F' => 'Female'], $model->gender);
    }

    public function testConstants()
    {
        $this->assertSame([
            'MALE' => 'M',
            'FEMALE' => 'F',
        ], GenderCode::constants());
    }
}
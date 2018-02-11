<?php

namespace tigrov\tests\unit\enum\data;

class GenderCode extends \tigrov\enum\EnumBehavior
{
    const MALE = 'M';
    const FEMALE = 'F';

    /**
     * @var array list of attributes that are to be automatically humanized value.
     * humanized => original attribute
     */
    public $attributes = ['gender' => 'gender_code'];

    /**
     * Returns default value (it uses if the attribute value is null)
     * @return string|null
     */
    public static function defaultValue()
    {
        return 'Unspecified';
    }
}
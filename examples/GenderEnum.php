<?php
namespace tigrov\enum\examples;

use tigrov\enum\EnumBehavior;

class GenderEnum extends EnumBehavior
{
    const MALE = 'M';
    const FEMALE = 'F';

    /** @var array list of attributes that are to be automatically detected value */
    public $attributes = ['gender' => 'gender_code'];

    /** @var string a message category for translation the values */
    public static $messageCategory = 'app';
}
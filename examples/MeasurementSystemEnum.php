<?php
namespace tigrov\enum\examples;

use tigrov\enum\EnumBehavior;

class MeasurementSystemEnum extends EnumBehavior
{
    const METRIC = 'SI';
    const US = 'US';

    /** @var array list of attributes that are to be automatically detected value */
    public $attributes = ['measurementSystem' => 'measurement_system_code'];

    /**
     * Values of Measurement Systems
     * @param bool $withEmpty with empty value at first
     * @return array
     */
    public static function values($withEmpty = false)
    {
        return ($withEmpty ? ['' => static::emptyValue()] : []) + [
            static::METRIC => \Yii::t('app', 'International System (metre, kilogram)'),
            static::US => \Yii::t('app', 'United States (inch, pound)'),
        ];
    }
}
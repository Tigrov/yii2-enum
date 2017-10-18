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
     *
     * @return array
     */
    public static function values()
    {
        return [
            static::METRIC => \Yii::t('app', 'International System (metre, kilogram)'),
            static::US => \Yii::t('app', 'United States (inch, pound)'),
        ];
    }
}
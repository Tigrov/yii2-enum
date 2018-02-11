<?php
/**
 * @link https://github.com/tigrov/yii2-enum
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */

namespace tigrov\enum;

use yii\base\Behavior;
use yii\helpers\Inflector;

/**
 * Parent class for an enum type behavior. Allows to get humanized value of the enum type based on class constants.
 *
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */
abstract class EnumBehavior extends Behavior
{
    /**
     * @var array list of attributes that are to be automatically humanized value.
     * humanized => original attribute
     */
    public $attributes = [];

    /** @var string|null a message category for translation the values */
    public static $messageCategory;

    /**
     * Translates a message. @see \Yii::t()
     * @param string $value
     * @return string
     */
    public static function t($value)
    {
        return static::$messageCategory
            ? \Yii::t(static::$messageCategory, $value)
            : $value;
    }

    /**
     * Returns display values of the enum type
     * @return array [ code => value ]
     */
    public static function values() {
        static $list = [];

        $className = static::className();
        if (!isset($list[$className])) {
            foreach (static::constants() as $value => $code) {
                $value = Inflector::humanize(strtolower($value), true);
                $list[$className][$code] = static::t($value);
            }
        }

        return $list[$className];
    }

    /**
     * Returns a display value for $code
     * @param string $code the value of a class constant
     * @return string
     */
    public static function value($code)
    {
        return static::values()[$code];
    }

    /**
     * Returns a boolean indicating whether the enum has a value.
     * @param string $code the value of a class constant
     * @return bool
     */
    public static function has($code)
    {
        return isset(static::values()[$code]);
    }

    /**
     * Returns codes of the enum type
     * @return array
     */
    public static function codes()
    {
        return array_keys(static::values());
    }

    /**
     * Returns constants of the class
     * @return array constant name in key, constant value in value.
     */
    public static function constants()
    {
        $class = new \ReflectionClass(static::className());
        return $class->getConstants();
    }

    /**
     * Returns default value (it will be used if the attribute value is empty)
     * @return string|null
     */
    public static function defaultValue()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return isset($this->attributes[$name]) || parent::canGetProperty($name, $checkVars);
    }

    /**
     * @inheritdoc
     * Returns default value if the attribute value is empty
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            if ($code = $this->owner->{$this->attributes[$name]}) {
                if (is_array($code)) {
                    return array_intersect_key(static::values(), array_flip($code));
                }

                return static::value($code);
            } else {
                return static::defaultValue();
            }
        }

        return parent::__get($name);
    }
}
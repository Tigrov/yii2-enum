<?php

namespace tigrov\enum\examples;

use Yii;
use yii\helpers\ArrayHelper;
use yii\validators\ValidationAsset;
use yii\validators\Validator;

/**
 * EnumValidator validates that the attribute value is among a list of enum values.
 *
 * @author Sergei Tigrov <rrr-r@ya.ru>
 */
class EnumValidator extends Validator
{
    /**
     * @var array a list of valid values that the attribute value should be among or an anonymous function that returns
     * such a list.
     */
    protected $range;
    /**
     * @var bool whether the comparison is strict (both type and value must be the same)
     */
    public $strict = false;
    /**
     * @var bool whether to allow array type attribute.
     */
    public $allowArray = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is invalid.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $in = false;

        if ($this->allowArray
            && ($value instanceof \Traversable || is_array($value))
            && ArrayHelper::isSubset($value, $this->range, $this->strict)
        ) {
            $in = true;
        }

        if (!$in && ArrayHelper::isIn($value, $this->range, $this->strict)) {
            $in = true;
        }

        return $in ? null : [$this->message, []];
    }

    /**
     * @inheritdoc
     * @param \yii\db\ActiveRecord $model the model being validated
     */
    public function validateAttribute($model, $attribute)
    {
        $this->range = $model::getTableSchema()->getColumn($attribute)->enumValues;
        parent::validateAttribute($model, $attribute);
    }

    /**
     * @inheritdoc
     * @param \yii\db\ActiveRecord $model the model being validated
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        ValidationAsset::register($view);
        $options = $this->getClientOptions($model, $attribute);

        return 'yii.validation.range(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }

    /**
     * @inheritdoc
     * @param \yii\db\ActiveRecord $model the model being validated
     */
    public function getClientOptions($model, $attribute)
    {
        $options = [
            'range' => $model::getTableSchema()->getColumn($attribute)->enumValues,
            'not' => false,
            'message' => $this->formatMessage($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ]),
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }
        if ($this->allowArray) {
            $options['allowArray'] = 1;
        }

        return $options;
    }
}
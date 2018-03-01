<?php

namespace tigrov\enum\examples;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $gender_code
 *
 * @property string $gender
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'gender' => GenderEnum::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender_code'], EnumValidator::class],
            [['first_name', 'last_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender_code' => Yii::t('app', 'Gender'),
        ];
    }
}

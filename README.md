yii2-enum
==============

Enum type behavior for Yii2 based on class constants.

[![Latest Stable Version](https://poser.pugx.org/Tigrov/yii2-enum/v/stable)](https://packagist.org/packages/Tigrov/yii2-enum)
[![Build Status](https://travis-ci.org/Tigrov/yii2-enum.svg?branch=master)](https://travis-ci.org/Tigrov/yii2-enum)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tigrov/yii2-enum
```

or add

```
"tigrov/yii2-enum": "~1.0"
```

to the require section of your `composer.json` file.

	
Usage
-----

Once the extension is installed, you can create an enum behavior as follow:

```php
class Status extends \tigrov\enum\EnumBehavior
{
    const ACTIVE = 'active';
    const PENDING = 'pending';
    const REJECTED = 'rejected';
    const DELETED = 'deleted';

    /** @var array list of attributes that are to be automatically humanized value */
    public $attributes = ['status' => 'status_key'];
    
    /** @var string|null a message category for translation the values */
    public static $messageCategory = 'status';
}
```

Create a table with the enum field
```php
\Yii::$app->getDb()->createCommand()
    ->createTable('model', [
       'id' => 'pk',
       'status_key' => 'string',
   ])->execute();
```

Create a model for the table
```php
class Model extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            Status::className(),
            // 'status' => [
            //     'class' => Status::className(),
            //     'attributes' => ['status' => 'status_key'],
            // ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_key'], 'in', 'range' => Status::codes()],
        ];
    }
}
```

and then use them in your code
```php
/**
 * @var ActiveRecord $model
 */
$model = new Model;
$model->status_key = Status::PENDING;

// The field 'status' has humanize and translated value, see \yii\helpers\Inflector::humanize($word, true)
$model->status; // is 'Pending' or translated value

// To get all enum values
Status::values();

// To get a display value
Status::value(Status::PENDING); // is 'Pending' or translated value
```

Examples
--------

Gender codes:
```php
class GenderEnum extends \tigrov\enum\EnumBehavior
{
    const MALE = 'M';
    const FEMALE = 'F';

    /**
     * @var array list of attributes that are to be automatically humanized value
     * humanized => original attribute
     */
    public $attributes = ['gender' => 'gender_code'];
    
    /** @var string|null a message category for translation the values */
    public static $messageCategory = 'gender';
    
    /**
    * Returns default value (it will be used if the attribute value is empty)
    * @return string|null
    */
    public static function defaultValue()
    {
        return static::t('Unspecified');
    }
}

class Model extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            GenderEnum::className(),
        ];
    }
    
    public function rules()
    {
        return [
            [['gender_code'], 'in', 'range' => GenderEnum::codes()],
        ];
    }
}

$model->gender_code = GenderEnum::MALE; // is 'M'

// The field 'gender' has humanize and translated value
$model->gender; // is 'Male' or translated value

$model->gender_code = null;
$model->gender; // is 'Unspecified' or translated value. @see GenderEnum::defaultValue()
```

Messenger names:
```php
class MessengerEnum extends \tigrov\enum\EnumBehavior
{
    const SKYPE = 'skype';
    const WHATSAPP = 'whatsapp';
    const VIBER = 'viber';
    const FACEBOOK = 'facebook';
    const IMESSAGE = 'imessage';
    const TELEGRAM = 'telegram';
    const LINE = 'line';
    const JABBER = 'jabber';
    const QQ = 'qq';
    const BLACKBERRY = 'blackberry';
    const AIM = 'aim';
    const EBUDDY = 'ebuddy';
    const YAHOO = 'yahoo';
    const OTHER = 'other';
    
    /** @var array list of attributes that are to be automatically humanized value */
    public $attributes = ['type' => 'type_key'];
        
    /**
     * Values of Messengers
     * @return array
     */
    public static function values()
    {
        $values = parent::values();
        
        // Correct some values
        $values['whatsapp'] = 'WhatsApp';
        $values['imessage'] = 'iMessage';
        $values['qq'] = 'QQ';
        $values['blackberry'] = 'BlackBerry';
        $values['aim'] = 'AIM';
        $values['ebuddy'] = 'eBuddy';
        $values['other'] = \Yii::t('enum', 'Other'),
        
        return $values;
    }
}

$model->type_key = MessengerEnum::WHATSAPP; // is 'whatsapp'
$model->type; // is 'WhatsApp'
```

License
-------

[MIT](LICENSE)

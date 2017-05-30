<?php

namespace tigrov\tests\unit\enum\data;

use yii\db\ActiveRecord;

class Model extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            GenderCode::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['id', 'gender_code'];
    }
}
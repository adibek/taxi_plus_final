<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Gender extends ActiveRecord
{

    public static function tableName() {
        return "genders";
    }

    public function rules()
    {
        return [
            [['id', 'gender'], 'safe'],
        ];
    }
}

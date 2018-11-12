<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Company extends ActiveRecord
{

    public static function tableName() {
        return "company";
    }

    public function rules()
    {
        return [
            [['id', 'name', 'balance'], 'safe'],
        ];
    }
}

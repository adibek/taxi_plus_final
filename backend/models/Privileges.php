<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Privileges extends ActiveRecord
{

    public static function tableName() {
        return "privileges";
    }

    public function rules()
    {
        return [
            [['id', 'name', 'price'], 'safe'],
        ];
    }
}

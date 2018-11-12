<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Log extends ActiveRecord
{

    public static function tableName() {
        return "logs";
    }

    public function rules()
    {
        return [
            [['id', 'response', 'comment'], 'safe'],
        ];
    }
}

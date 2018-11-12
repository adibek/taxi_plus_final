<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Facilities extends ActiveRecord
{

    public static function tableName() {
        return "facilities";
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
        ];
    }
}

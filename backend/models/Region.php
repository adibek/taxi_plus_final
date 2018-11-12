<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Region extends ActiveRecord
{

    public static function tableName() {
        return "regions";
    }

    public function rules()
    {
        return [
            [['id', 'name'], 'safe'],
        ];
    }
}

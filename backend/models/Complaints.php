<?php

namespace backend\models;

use yii\db\ActiveRecord;


class Complaints extends ActiveRecord
{

    public static function tableName() {
        return "complaints";
    }

    public function rules()
    {
        return [
            [['id', 'text', 'user_id', 'order_id', 'created'], 'safe'],
        ];
    }
}

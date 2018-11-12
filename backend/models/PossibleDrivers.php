<?php

namespace backend\models;

use yii\db\ActiveRecord;


class PossibleDrivers extends ActiveRecord
{

    public static function tableName() {
        return "possible_drivers";
    }

    public function rules()
    {
        return [
            [['id', 'order_id', 'driver_id', 'created'], 'safe'],
        ];
    }
}

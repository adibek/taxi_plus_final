<?php

namespace backend\models;

use yii\db\ActiveRecord;


class DriversRatings extends ActiveRecord
{

    public static function tableName() {
        return "drivers_ratings";
    }

    public function rules()
    {
        return [
            [['id', 'driver_id', 'value'], 'safe'],
        ];
    }
}

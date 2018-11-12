<?php

namespace backend\models;

use yii\db\ActiveRecord;


class TaxiPark extends ActiveRecord
{

    public static function tableName() {
        return "taxi_park";
    }

    public function rules()
    {
        return [
            [['id', 'name', 'type', 'city_id', 'balance', 'is_radial'], 'safe'],
        ];
    }
}

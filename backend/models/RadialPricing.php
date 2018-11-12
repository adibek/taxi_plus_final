<?php

namespace backend\models;

use yii\db\ActiveRecord;


class RadialPricing extends ActiveRecord
{

    public static function tableName() {
        return "radial_pricing";
    }

    public function rules()
    {
        return [
            [['id', 'taxi_park_id', 'service_id', 'meters','tenge', 'session_price', 'session_price_unlim'], 'safe'],
        ];
    }
}

<?php

namespace backend\models;

use yii\db\ActiveRecord;


class TaxiParkServices extends ActiveRecord
{

    public static function tableName() {
        return "taxi_park_services";
    }

    public function rules()
    {
        return [
            [['id', 'taxi_park_id', 'service_id', 'call_price','km_price', 'commision_percent', 'session_price', 'session_price_unlim', 'meters','tenge'], 'safe'],
        ];
    }
}

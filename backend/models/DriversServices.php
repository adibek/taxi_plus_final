<?php

namespace backend\models;

use yii\db\ActiveRecord;


class DriversServices extends ActiveRecord
{

    public static function tableName() {
        return "drivers_services";
    }

    public function rules()
    {
        return [
            [['id', 'driver_id', 'service_id'], 'safe'],
        ];
    }
}

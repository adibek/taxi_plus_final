<?php

namespace backend\models;

use yii\db\ActiveRecord;


class UsersCars extends ActiveRecord
{

    public static function tableName() {
        return "users_cars";
    }

    public static function tableFields(){
        return ['id', 'user_id', 'car_id', 'seats_number', 'tonns', 'number', 'year', 'body', 'created'];
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'car_id', 'seats_number', 'tonns', 'number', 'year', 'body', 'type', 'created'], 'safe'],
        ];
    }
}

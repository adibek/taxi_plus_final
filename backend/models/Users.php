<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Response;


class Users extends ActiveRecord
{

    public static function tableName() {
        return "users";
    }

    public function rules()
    {
        return [
            [['id', 'parent_id', 'platform', 'rating', 'role_id', 'name', 'balance', 'email', 'password', 'phone', 'is_active',  'created', 'taxi_park_id', 'push_id', 'email', 'city_id', 'taxi_park_id', 'token', 'gender', 'year_of_birth'], 'safe'],
        ];
    }
    public static function findOneUser($token){
        $user = Users::find()->where(['token' => $token])->one();
        return $user;
    }
}

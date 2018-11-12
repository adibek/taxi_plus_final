<?php

namespace backend\models;

use yii\db\ActiveRecord;


class SystemUsers extends ActiveRecord
{
//    public $first_name;
//    public $last_name;
//    public $email;
//    public $phone;
//    public $role_id;
//    public $taxi_park_id;
//    public $created;
//    public $password;

    public static function tableName() {
        return "system_users";
    }

    public static function tableFields(){
        return ['id', 'email', 'password', 'email', 'first_name', 'last_name', 'phone', 'role_id', 'company_id', 'taxi_park_id', 'last_edit', 'created'];
    }

    public function rules()
    {
        return [
            [['email', 'last_name', 'password', 'first_name', 'role_id', 'taxi_park_id', 'created'], 'required'],
            [self::tableFields(), 'safe']
        ];
    }
}

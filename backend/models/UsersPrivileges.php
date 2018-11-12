<?php

namespace backend\models;

use yii\db\ActiveRecord;


class UsersPrivileges extends ActiveRecord
{

    public static function tableName() {
        return "users_privileges";
    }

    public function rules()
    {
        return [
            [['id', 'privileges_id', 'user_id'], 'safe'],
        ];
    }
}

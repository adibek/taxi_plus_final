<?php

namespace backend\models;

use yii\db\ActiveRecord;


class UsersAvatars extends ActiveRecord
{

    public static function tableName() {
        return "users_avatars";
    }

    public static function tableFields(){
        return ['id', 'user_id', 'path', 'created'];
    }

    public function rules()
    {
        return [
            [['id', 'user_id', 'path', 'created'], 'safe'],
        ];
    }
}

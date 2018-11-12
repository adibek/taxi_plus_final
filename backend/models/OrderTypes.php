<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/19/18
 * Time: 11:16 AM
 */
namespace backend\models;

use yii\db\ActiveRecord;


class OrderTypes extends ActiveRecord
{

    public static function tableName() {
        return "order_types";
    }

    public function rules()
    {
        return [
            [['id', 'type', 'hour_price', 'publish_price'], 'safe'],
        ];
    }
}

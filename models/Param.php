<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "param".
 *
 * @property int $id
 * @property string $paramName
 */
class Param extends \yii\db\ActiveRecord
{
    const ATTACK_TYPE_ID = 12;

    public static function tableName()
    {
        return 'param';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paramName'], 'required'],
            [['paramName'], 'string', 'max' => 255],
            [['paramName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paramName' => 'Param Name',
        ];
    }
}

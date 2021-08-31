<?php

namespace app\models;

use Yii;
use app\models\Param;

/**
 * This is the model class for table "mob_param".
 *
 * @property int $mobId
 * @property int $paramId
 * @property string $paramValue
 * @property Param $paramName
 */
class MobParam extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mob_param';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobId', 'paramId', 'paramValue'], 'required'],
            [['mobId', 'paramId'], 'integer'],
            [['paramValue'], 'string', 'max' => 255],
            [['mobId', 'paramId'], 'unique', 'targetAttribute' => ['mobId', 'paramId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mobId' => 'Mob ID',
            'paramId' => 'Param ID',
            'paramValue' => 'Param Value',
        ];
    }

    public function getParam()
    {
        return $this->hasOne(Param::className(), ['id' => 'paramId']);
    }

}

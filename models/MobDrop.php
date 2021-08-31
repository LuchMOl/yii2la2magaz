<?php

namespace app\models;

use Yii;
use app\models\Item;

/**
 * This is the model class for table "mob_drop".
 *
 * @property int $mobId
 * @property int $itemId
 * @property string $description
 * @property Item $Item
 */
class MobDrop extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mob_drop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobId', 'itemId', 'description'], 'required'],
            [['mobId', 'itemId'], 'integer'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mobId' => 'Mob ID',
            'itemId' => 'Item ID',
            'description' => 'Description',
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'itemId']);
    }

}

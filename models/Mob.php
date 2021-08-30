<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mob".
 *
 * @property int $id
 * @property string $title
 * @property string|null $img
 * @property int $relatedUrlId
 * @property string $imageFileName
 */
class Mob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mob';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'relatedUrlId', 'imageFileName'], 'required'],
            [['relatedUrlId'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],
            [['imageFileName'], 'string', 'max' => 15],
            [['relatedUrlId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'img' => 'Img',
            'relatedUrlId' => 'Related Url ID',
            'imageFileName' => 'Image File Name',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $title
 * @property string $imgUri
 * @property string $imageFileName
 * @property string $itemUrl
 * @property int $isParsed
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'imgUri', 'imageFileName', 'itemUrl'], 'required'],
            [['isParsed'], 'integer'],
            [['title', 'imgUri', 'itemUrl'], 'string', 'max' => 255],
            [['imageFileName'], 'string', 'max' => 15],
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
            'imgUri' => 'Img Uri',
            'imageFileName' => 'Image File Name',
            'itemUrl' => 'Item Url',
            'isParsed' => 'Is Parsed',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skill".
 *
 * @property int $id
 * @property string $imgUri
 * @property string $title
 * @property string $description
 * @property string $imageFileName
 */
class Skill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imgUri', 'title', 'description', 'imageFileName'], 'required'],
            [['imgUri'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 700],
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
            'imgUri' => 'Img Uri',
            'title' => 'Title',
            'description' => 'Description',
            'imageFileName' => 'Image File Name',
        ];
    }
}

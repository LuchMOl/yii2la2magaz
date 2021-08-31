<?php

namespace app\models;

use Yii;
use app\models\Skill;

/**
 * This is the model class for table "mob_skill".
 *
 * @property int $mobId
 * @property int $skillId
 * @property Skill $skill
 */
class MobSkill extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mob_skill';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobId', 'skillId'], 'required'],
            [['mobId', 'skillId'], 'integer'],
            [['mobId', 'skillId'], 'unique', 'targetAttribute' => ['mobId', 'skillId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mobId' => 'Mob ID',
            'skillId' => 'Skill ID',
        ];
    }

    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'skillId']);
    }
}

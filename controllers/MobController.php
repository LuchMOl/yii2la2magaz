<?php

namespace app\controllers;

use app\models\Mob;
use app\models\MobParam;
use app\models\Skill;
use app\models\MobSkill;
use app\models\MobDrop;
use app\models\MobSweep;
use app\models\Param;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\helpers\ArrayHelper;

class MobController extends \yii\web\Controller
{

    public function actionIndex()
    {
        //var_dump($_GET['Типы-атаки']);die;
        $quantityItemInPage = 30;

        $quantityPages = $this->getQuantityPages($quantityItemInPage);

        $currentPageNumber = $this->checkPagesRange($quantityPages);

        $attackTypeList = $this->getParamList($this->getParamId('Тип атаки'));

        $raceList = $this->getRaceList();

        $mobsForPage = $this->getMobsForPage($quantityItemInPage, $currentPageNumber);

        return $this->render('index', compact('mobsForPage',
                                'currentPageNumber',
                                'quantityPages',
                                'attackTypeList',
                                'raceList'));
    }

    public function actionView()
    {
        if (isset($_GET['id'])) {
            $mob = Mob::find()
                    ->where(['id' => $_GET['id']])
                    ->one();

            $mobParam = MobParam::find()
                    ->where(['mobId' => $_GET['id']])
                    ->all();

            $mobSkill = MobSkill::find()
                    ->where(['mobId' => $_GET['id']])
                    ->all();

            $mobDrop = MobDrop::find()
                    ->where(['mobId' => $_GET['id']])
                    ->all();

            $mobSweep = MobSweep::find()
                    ->where(['mobId' => $_GET['id']])
                    ->all();
        }

        return $this->render('singleMob', compact('mob', 'mobParam', 'mobSkill', 'mobDrop', 'mobSweep'));
    }

    public function getQuantityPages($quantityItemInPage)
    {
        $mobCount = Mob::find()
                ->count();

        $quantityPages = ceil($mobCount / $quantityItemInPage);
        return $quantityPages;
    }

    public function checkPagesRange($quantityPages)
    {
        if (isset($_GET['pageNumber'])) {

            $currentPageNumber = $_GET['pageNumber'];

            if ($currentPageNumber < 1) {
                $currentPageNumber = 1;
                $this->redirect('/mob/?pageNumber=1');
            } elseif ($currentPageNumber > $quantityPages) {
                $currentPageNumber = $quantityPages;
                $this->redirect('/mob/?pageNumber=' . $quantityPages);
            }
        } else {
            $currentPageNumber = 1;
            $this->redirect('/mob/?pageNumber=1');
        }
        return $currentPageNumber;
    }

    public function getMobsForPage($quantityItemInPage, $currentPageGet)
    {
        if (isset($_GET['attackType'])) {

            $mobsIdWithAttackType = MobParam::find()
                    ->where(['paramValue' => $_GET['attackType']])
                    ->asArray()
                    ->all();

            $mobsIdWithAttackType = ArrayHelper::getColumn($mobsIdWithAttackType, 'mobId');

            $mobsForPage = Mob::find()
                    ->where(['id' => $mobsIdWithAttackType])
                    ->offset($quantityItemInPage * ($currentPageGet - 1))
                    ->limit($quantityItemInPage)
                    ->all();
        } elseif ($_GET['race']) {
            $skillId = $this->getSkillIdWhere($title = 'Race', $description = $_GET['race']);

            $mobsIdWithRace = MobSkill::find()
                    ->select('mobId')
                    ->where(['skillId' => $skillId])
                    ->asArray()
                    ->all();
            //var_dump($mobsIdWithRace);die;

            $mobsIdWithRace = ArrayHelper::getColumn($mobsIdWithRace, 'mobId');

            $mobsForPage = Mob::find()
                    ->where(['id' => $mobsIdWithRace])
                    ->offset($quantityItemInPage * ($currentPageGet - 1))
                    ->limit($quantityItemInPage)
                    ->all();
        }
        return $mobsForPage;
    }

    public function getParamId($paramName)
    {
        $paramId = Param::find()
                ->where(['paramName' => $paramName])
                ->one();
        return $paramId->id;
    }

    public function getParamList($paramId)
    {
        $paramList = MobParam::find()
                ->select('paramValue')
                ->distinct()
                ->where(['paramId' => $paramId])
                ->asArray()
                ->all();
        $paramList = ArrayHelper::getColumn($paramList, 'paramValue');

        return $paramList;
    }

    public function getRaceList()
    {
        $raceList = Skill::find()
                ->select('description')
                ->distinct()
                ->where(['title' => 'Race'])
                ->asArray()
                ->all();
        $raceList = ArrayHelper::getColumn($raceList, 'description');

        return $raceList;
    }

    public function getSkillIdWhere($title, $description)
    {
        $skillId = Skill::find()
                ->select('id')
                ->andWhere(['title' => $title])
                ->andWhere(['description' => $description])
                ->one();
        //var_dump($skillId);die;
        return $skillId;
    }

}

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

        $quantityItemInPage = 30;

        $attackTypeList = $this->getParamList($this->getParamId('Тип атаки'));

        $raceList = $this->getRaceList();

        $idsMobs = $this->getIdsMobsWithFilter();
        $countMobs = count($idsMobs);

        $quantityPages = $this->getQuantityPages($idsMobs, $quantityItemInPage);

        $currentPageNumber = $this->checkPagesRange($quantityPages);

        $mobsForPage = $this->getMobsForPage($idsMobs, $quantityItemInPage, $currentPageNumber);

        //var_dump($currentPageNumber);die;

        return $this->render('index', compact('mobsForPage',
                                'currentPageNumber',
                                'countMobs',
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

    public function getQuantityPages($idsMobs, $quantityItemInPage)
    {
        if ($idsMobs) {
            $mobCount = count($idsMobs);
        } else {
            $mobCount = Mob::find()
                    ->count();
        }

        $quantityPages = ceil($mobCount / $quantityItemInPage);

        return $quantityPages;
    }

    public function checkPagesRange($quantityPages)
    {
        $stringGetParam = strstr($_SERVER["REQUEST_URI"], '&');
        if ($_GET['page-number']) {

            $currentPageNumber = $_GET['page-number'];

            if ($currentPageNumber < 1) {
                $currentPageNumber = 1;
                $this->redirect('/mob/?page-number=1' . $stringGetParam);
            } elseif ($currentPageNumber > $quantityPages) {
                $currentPageNumber = $quantityPages;
                $this->redirect('/mob/?page-number=' . $quantityPages . $stringGetParam);
            }
        } else {
            $currentPageNumber = 1;
            $this->redirect('/mob/?page-number=1' . $stringGetParam);
        }
        return $currentPageNumber;
    }

    public function getIdsMobsWithFilter()
    {
        $idsAllMobs = Mob::find()
                ->select('id')
                ->asArray()
                ->all();
        $idsAllMobs = ArrayHelper::getColumn($idsAllMobs, 'id');

        if ($_GET['attack-type']) {

            $attackTypeValues = explode(',', $_GET['attack-type']);

            $idsMobs = MobParam::find()
                    ->where(['paramValue' => $attackTypeValues])
                    ->asArray()
                    ->all();
            $idsMobsAttackType = ArrayHelper::getColumn($idsMobs, 'mobId');
        } else {
            $idsMobsAttackType = $idsAllMobs;
        }

        if ($_GET['race']) {

            $raceValues = explode(',', $_GET['race']);

            $skillId = $this->getSkillIdWhere($title = 'Race', $description = $raceValues);
            $skillId = ArrayHelper::getColumn($skillId, 'id');

            $idsMobs = MobSkill::find()
                    ->select('mobId')
                    ->where(['skillId' => $skillId])
                    ->asArray()
                    ->all();

            $idsMobsRace = ArrayHelper::getColumn($idsMobs, 'mobId');
        } else {
            $idsMobsRace = $idsAllMobs;
        }

        if ($_GET['with-photo'] == 1) {

            $idsMobs = Mob::find()
                    ->select('id')
                    ->where(['not', ['imageFileName' => '']])
                    ->asArray()
                    ->all();
            $idsMobsPhoto = ArrayHelper::getColumn($idsMobs, 'id');
        } else {
            $idsMobsPhoto = $idsAllMobs;
        }

        if ($idsMobsAttackType || $idsMobsRace || $idsMobsPhoto) {
            $idsMobs = array_intersect($idsMobsAttackType, $idsMobsRace, $idsMobsPhoto);
        } else {
            $idsMobs = $idsAllMobs;
        }


        return $idsMobs;
    }

    public function getMobsForPage($idsMobs, $quantityItemInPage, $currentPageGet)
    {
        //var_dump($idsMobs);die;
        if ($idsMobs) {
            $mobsForPage = Mob::find()
                    ->where(['id' => $idsMobs])
                    ->offset($quantityItemInPage * ($currentPageGet - 1))
                    ->limit($quantityItemInPage)
                    ->all();
        } else {
//            $mobsForPage = Mob::find()
//                    ->offset($quantityItemInPage * ($currentPageGet - 1))
//                    ->limit($quantityItemInPage)
//                    ->all();
            $mobsForPage = [];
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
                ->asArray()
                ->all();
        //var_dump($skillId);die;
        return $skillId;
    }

}

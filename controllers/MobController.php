<?php

namespace app\controllers;

use Yii;
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

const QUANTYITY_ITEM_IN_PAGE = 30;

class MobController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $attackTypeList = $this->getParamList(Param::ATTACK_TYPE_ID);

        $raceList = $this->getRaceList();

        $countMobs = $this->countMobsWithFilters();

        $quantityPages = $this->getQuantityPages($countMobs);

        $currentPageNumber = $this->checkPagesRange($quantityPages);

        $mobsForPage = $this->getMobsForPageWithFilter($currentPageNumber);

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

    public function getParamList($paramId)
    {
        $paramList = MobParam::find()
                ->select('paramValue')
                ->distinct()
                ->where(['paramId' => $paramId])
                ->all();

        return $paramList;
    }

    public function getRaceList()
    {
        $raceList = Skill::find()
                ->select('description')
                ->distinct()
                ->where(['title' => Skill::RACE])
                ->all();

        $noRace = new Skill();
        $noRace->description = 'Без рассы';
        $raceList[] = $noRace;

        return $raceList;
    }

    public function countMobsWithFilters()
    {
        $filtersQueryPart = $this->buildFiltersQueryPart();

        if ($filtersQueryPart != -1) {
            $quantityMobs = Yii::$app->db->createCommand("SELECT COUNT(m.id)
                                    FROM mob AS m
                                    LEFT JOIN mob_skill AS m_s ON m_s.mobId = m.id
                                    JOIN skill AS s ON m_s.skillId = s.id AND s.title = '" . Skill::RACE . "'
                                    JOIN mob_param AS m_p ON m_p.mobId = m.id AND m_p.paramId = '" . Param::ATTACK_TYPE_ID . "'
                                    WHERE " . $filtersQueryPart)
                    ->queryScalar();
        } else {
            $quantityMobs = Mob::find()
                    ->count();
        }

        return $quantityMobs;
    }

    public function getQuantityPages($countMobs)
    {
        if ($countMobs < QUANTYITY_ITEM_IN_PAGE) {
            $quantityPages = 1;
        } else {
            $quantityPages = ceil($countMobs / QUANTYITY_ITEM_IN_PAGE);
        }

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

    public function getMobsForPageWithFilter($currentPageNumber)
    {
        $filtersQueryPart = $this->buildFiltersQueryPart();

        if ($filtersQueryPart != -1) {

            $mobs = Mob::findBySql("SELECT m.*
                                    FROM mob AS m
                                    LEFT JOIN mob_skill AS m_s ON m_s.mobId = m.id
                                    JOIN skill AS s ON m_s.skillId = s.id AND s.title = '" . Skill::RACE . "'
                                    JOIN mob_param AS m_p ON m_p.mobId = m.id AND m_p.paramId = '" . Param::ATTACK_TYPE_ID . "'
                                    WHERE " . $filtersQueryPart . "
                                    LIMIT " . (QUANTYITY_ITEM_IN_PAGE) . "
                                    OFFSET " . (QUANTYITY_ITEM_IN_PAGE * ($currentPageNumber - 1)))
                    ->all();
        } else {
            $mobs = Mob::find()
                    ->offset(QUANTYITY_ITEM_IN_PAGE * ($currentPageNumber - 1))
                    ->limit(QUANTYITY_ITEM_IN_PAGE)
                    ->all();
        }

        return $mobs;
    }

    public function buildFiltersQueryPart()
    {
        if ($_GET['attack-type'] && count(explode(',', $_GET['attack-type'])) > 0) {
            $attackTypeQueryString = "(m_p.paramValue = '" . implode("' OR m_p.paramValue = '", explode(',', $_GET['attack-type'])) . "')";
        }

        if ($_GET['race'] && count(explode(',', $_GET['race'])) > 0) {

            $raceArr = explode(',', $_GET['race']);
            if (in_array('no-race', $raceArr)) {
                unset($raceArr[array_search('no-race',$raceArr)]);
            }

            $raceQueryString = "(s.description = '" . implode("' OR s.description = '", $raceArr) . "')";
        }

        if ($attackTypeQueryString && $raceQueryString) {
            $queryString = "$attackTypeQueryString AND $raceQueryString";
        } elseif ($attackTypeQueryString) {
            $queryString = $attackTypeQueryString;
        } elseif ($raceQueryString) {
            $queryString = $raceQueryString;
        } else {
            $queryString = -1;
        }

        if ($_GET['with-photo']) {
            if ($queryString != -1) {
                $queryString = $queryString . " AND m.imageFileName <> '' ";
            } else {
                $queryString = "m.imageFileName <> '' ";
            }
        }

        return $queryString;
    }

}

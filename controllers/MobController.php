<?php

namespace app\controllers;

use app\models\Mob;
use app\models\MobParam;
use app\models\MobSkill;
use app\models\MobDrop;
use app\models\MobSweep;
use yii\helpers\Url;
use yii\web\YiiAsset;

class MobController extends \yii\web\Controller
{

    public function actionIndex()
    {
        $quantityItemInPage = 20;

        $mobCount = Mob::find()
                ->count();

        $quantityPages = ceil($mobCount / $quantityItemInPage);

        if (isset($_GET['page'])) {
            $currentPageGet = $_GET['page'];

            if ($currentPageGet < 1) {
                $currentPageGet = 1;
                $this->redirect('/mob/?page=1');
            } elseif ($currentPageGet > $quantityPages) {
                $currentPageGet = $quantityPages;
                $this->redirect('/mob/?page=' . $quantityPages);
            }
        } else {
            $currentPageGet = 1;
            $this->redirect('/mob/?page=1');
        }

        $mobsForPage = Mob::find()
                ->offset($quantityItemInPage * ($currentPageGet - 1))
                ->limit($quantityItemInPage)
                ->all();

        return $this->render('index', compact('mobsForPage', 'currentPageGet', 'quantityPages'));
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

}

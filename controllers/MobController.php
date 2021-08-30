<?php

namespace app\controllers;

use app\models\Mob;
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

        $mobForPage = Mob::find()
                ->offset($quantityItemInPage * ($currentPageGet - 1))
                ->limit($quantityItemInPage)
                ->all();

        return $this->render('index', compact('mobForPage', 'currentPageGet', 'quantityPages'));
    }

}

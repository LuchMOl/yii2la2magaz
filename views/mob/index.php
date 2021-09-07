<?php

namespace app\views;

use app\services\FilterService;

/* @var $this yii\web\View */

$filterService = new FilterService();

define("MOB_IMAGE_PATH", "/i/l2db/mob/");
define("COUNT_OF_ROW", 5);

$count = 0;
$currentGetParamString = strstr($_SERVER["REQUEST_URI"], '&');
$currentGetAttackTypeArray = isset($_GET['attack-type']) ? explode(',', $_GET['attack-type']) : [];
$currentGetRaceArray = isset($_GET['race']) ? explode(',', $_GET['race']) : [];
?>

<div class="sidebar-container">
    <div class="sidebar-logo">
        Sidebar
    </div>

    <ul class="sidebar-navigation">
        <li class="header">Тип атаки</li>
        <?php foreach ($attackTypeList as $listElement) : ?>
            <li>
                <a href="?<?= $filterService->rebuildAttackTypeGetParameter($listElement); ?>">
                    <div class="form-check">
                        <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $filterService->checked($listElement, $currentGetAttackTypeArray); ?>>
                        <label class="form-check-label" for="flexCheckDefault">
                            <?= $listElement; ?>
                        </label>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Рассы</li>
        <?php foreach ($raceList as $listElement) : ?>
            <li>
                <a href="?<?= $filterService->rebuildRaceGetParameter($listElement); ?>">
                    <div class="form-check">
                        <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $filterService->checked($listElement, $currentGetRaceArray); ?>>
                        <label class="form-check-label" for="flexCheckDefault">
                            <?= $listElement; ?>
                        </label>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Фото</li>
        <li>
            <a href="?<?= $filterService->rebuildPhotoGetParameter(); ?>">
                <div class="form-check">
                    <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $_GET['with-photo'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="flexCheckDefault">
                        Только с фото
                    </label>
                </div>
            </a>
        </li>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">по уровню, слайдером</li>
        <li>
            <a href="#">
                <i class="fa fa-users" aria-hidden="true"></i> Friends
            </a>
        </li>
    </ul>

</div>

<div class="content-container">

    <div class="container-fluid">

        <div class="jumbotron">
            <?= $quantityPages; ?>
            <!-- BUTTONS -->
            <div class="row justify-content-center">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="?page-number=1<?= !$currentGetParamString ?: $currentGetParamString; ?>"> <button type="button" class="btn btn-info"><<</button> </a>
                    <a href="?page-number=<?= $currentPageNumber - 1 . $currentGetParamString; ?>"> <button type="button" class="btn btn-info"><</button> </a>
                <?php endif; ?>

                <button type="button" class="btn btn-info current-page-button"><?= $currentPageNumber; ?></button>

                <?php if ($currentPageNumber < $quantityPages): ?>
                    <a href="?page-number=<?= $currentPageNumber + 1 . $currentGetParamString; ?>"> <button type="button" class="btn btn-info"><?= $currentPageNumber + 1; ?></button> </a>

                    <?php if ($currentPageNumber < $quantityPages - 1): ?>
                        <a href="?page-number=<?= $currentPageNumber + 2 . $currentGetParamString; ?>"> <button type="button" class="btn btn-info"><?= $currentPageNumber + 2; ?></button> </a>
                    <?php endif; ?>

                    <a href="?page-number=<?= $currentPageNumber + 1 . $currentGetParamString; ?>"> <button type="button" class="btn btn-info">></button> </a>
                    <a href="?page-number=<?= $quantityPages . $currentGetParamString; ?>"> <button type="button" class="btn btn-info">>></button> </a>
                <?php endif; ?>
            </div>

            <!-- MOBS TILE -->
            <?php foreach ($mobsForPage as $mob) : ?>

                <?php if ($count % COUNT_OF_ROW == 0): ?><div class="row justify-content-center"><?php endif; ?>
                    <a href="view/?id=<?= $mob->id ?>">
                        <div class="col-<?= intdiv(12, COUNT_OF_ROW); ?> mob">

                            <div class="row">
                                <?php if ($mob->imageFileName !== ''): ?>
                                    <img class="img-thumbnail" src="<?= MOB_IMAGE_PATH . $mob->imageFileName ?>">
                                <?php else : ?>
                                    <img class="img-thumbnail" src="<?= MOB_IMAGE_PATH . 'noImage.jpg' ?>">
                                <?php endif; ?>
                            </div>

                            <div class="row" >
                                <p class="mob-title"><?= $mob->title ?></p>
                            </div>
                    </a>
                </div>

                <?php if ($count % COUNT_OF_ROW == COUNT_OF_ROW - 1): ?></div><?php endif; ?>

            <?php $count++; ?>

        <?php endforeach; ?>

    </div>
</div>
</div>
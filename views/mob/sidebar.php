<?php
use app\models\Skill;
use app\services\StringService;
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
                <a href="?<?= $filterService->rebuildAttackTypeGetParameter($listElement->paramValue); ?>">
                    <div class="form-check">
                        <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $filterService->checked($listElement->paramValue, $currentGetAttackTypeArray); ?>>
                        <label class="form-check-label" for="flexCheckDefault">
                            <?= ucfirst($listElement->paramValue); ?>
                        </label>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Рассы</li>
        <?php foreach ($raceList as $listElement) : ?>
            <?php $listElement = mb_strtolower($listElement->description); ?>
            <li>
                <a href="?<?= $filterService->rebuildRaceGetParameter($listElement); ?>">
                    <div class="form-check">
                        <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $filterService->checked($listElement, $currentGetRaceArray); ?>>
                        <label class="form-check-label" for="flexCheckDefault">
                            <?= StringService::mb_ucfirst($listElement); ?>
                        </label>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
<!--        <li>
            <a href="?<?= $filterService->rebuildRaceGetParameter(Skill::NO_RACE); ?>">
                <div class="form-check">
                    <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $filterService->checked(Skill::NO_RACE, $currentGetRaceArray); ?>>
                    <label class="form-check-label" for="flexCheckDefault">
                        Без рассы
                    </label>
                </div>
            </a>
        </li>-->
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

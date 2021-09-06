<?php
/* @var $this yii\web\View */

define("MOB_IMAGE_PATH", "/i/l2db/mob/");
define("COUNT_OF_ROW", 5);
$count = 0;
$currentGetParamString = strstr($_SERVER["REQUEST_URI"], '&');
$currentGetAttackTypeString = isset($_GET['attack-type']) ? $_GET['attack-type'] . ',' : '';
$currentGetAttackTypeArray = isset($_GET['attack-type']) ? explode(',', $_GET['attack-type']) : [];
$currentGetRaceString = isset($_GET['race']) ? $_GET['race'] . ',' : '';
$currentGetRaceArray = isset($_GET['race']) ? explode(',', $_GET['race']) : [];
?>

<div class="sidebar-container">
    <div class="sidebar-logo">
        Sidebar
    </div>

    <ul class="sidebar-navigation">
        <li class="header">Тип атаки</li>
        <?php foreach ($attackTypeList as $item) : ?>
            <li>
                <?php if (in_array($item, $currentGetAttackTypeArray)) : ?>
                    <?php $newGetAttackTypeArray = array_diff($currentGetAttackTypeArray, [$item]); ?>
                    <a href="?page-number=1<?php if ($newGetAttackTypeArray) : ?>&attack-type=<?= implode(",", $newGetAttackTypeArray); ?><?php endif ?>">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= $item; ?>
                            </label>
                        </div>
                    </a>
                <?php else : ?>
                    <a href="?page-number=1&attack-type=<?= $currentGetAttackTypeString . $item; ?>">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" >
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= $item; ?>
                            </label>
                        </div>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Рассы</li>
        <?php foreach ($raceList as $item) : ?>
        <?php $item = strtolower($item); ?>
            <li>
                <?php if (in_array($item, $currentGetRaceArray)) : ?>
                    <?php $newGetRaceArray = array_diff($currentGetRaceArray, [$item]); ?>
                    <a href="?page-number=1&race=<?= implode(",", $newGetRaceArray); ?>">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= $item; ?>
                            </label>
                        </div>
                    </a>
                <?php else : ?>
                    <a href="?page-number=1&race=<?= $currentGetRaceString . $item; ?>">
                        <div class="form-check">
                            <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" >
                            <label class="form-check-label" for="flexCheckDefault">
                                <?= $item; ?>
                            </label>
                        </div>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Фото</li>
        <li>
            <a href="?page-number=1&photo=1">
                <div class="form-check">
                    <input class="form-check-input mt-0" type="checkbox" value="" id="flexCheckDefault" <?= $_GET['photo'] ? 'checked' : ''; ?>>
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
                    <a href="?page-number=1&<?= $currentGetParamString; ?>"> <button type="button" class="btn btn-info"><<</button> </a>
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
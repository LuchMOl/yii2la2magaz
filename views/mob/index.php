<?php
/* @var $this yii\web\View */

define("MOB_IMAGE_PATH", "/i/l2db/mob/");
define("COUNT_OF_ROW", 5);
$count = 0;
//var_dump($listsForSidebarFilters);die;
?>

<div class="sidebar-container">
    <div class="sidebar-logo">
        Sidebar
    </div>

    <ul class="sidebar-navigation">
        <li class="header">Тип атаки</li>
        <?php foreach ($attackTypeList as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" <?= $item == $_GET['attackType'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="flexCheckDefault">
                    <li><a href="?pageNumber=<?= $currentPageNumber; ?>&attackType=<?= $item; ?>"><?= $item; ?></a></li>
                </label>
            </div>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">Рассы</li>
        <?php foreach ($raceList as $item) : ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" <?= $item == $_GET['race'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="flexCheckDefault">
                    <li><a href="?pageNumber=<?= $currentPageNumber; ?>&race=<?= $item; ?>"><?= $item; ?></a></li>
                </label>
            </div>
        <?php endforeach; ?>
    </ul>

    <ul class="sidebar-navigation">
        <li class="header">С фото без фото</li>
        <li>
            <a href="#">
                <i class="fa fa-users" aria-hidden="true"></i> Friends
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

        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">

            <!-- BUTTONS -->
            <div class="row justify-content-center">
                <?php if ($currentPageNumber > 1): ?>
                    <a href="?pageNumber=1"> <button type="button" class="btn btn-info"><<</button> </a>
                    <a href="?pageNumber=<?= $currentPageNumber - 1; ?>"> <button type="button" class="btn btn-info"><</button> </a>
                <?php endif; ?>

                <button type="button" class="btn btn-info">...</button>

                <?php if ($currentPageNumber < $quantityPages): ?>
                    <a href="?pageNumber=<?= $currentPageNumber + 1; ?>"> <button type="button" class="btn btn-info"><?= $currentPageNumber + 1; ?></button> </a>

                    <?php if ($currentPageNumber < $quantityPages - 1): ?>
                        <a href="?pageNumber=<?= $currentPageNumber + 2; ?>"> <button type="button" class="btn btn-info"><?= $currentPageNumber + 2; ?></button> </a>
                    <?php endif; ?>

                    <a href="?pageNumber=<?= $currentPageNumber + 1; ?>"> <button type="button" class="btn btn-info">></button> </a>
                    <a href="?pageNumber=<?= $quantityPages; ?>"> <button type="button" class="btn btn-info">>></button> </a>
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
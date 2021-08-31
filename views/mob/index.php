<?php
/* @var $this yii\web\View */

define("MOB_IMAGE_PATH", "/i/l2db/mob/");
define("COUNT_OF_ROW", 4);
$count = 0;
//var_dump($currentPageGet);die;
?>
<div class="row justify-content-center">
    <?php if ($currentPageGet > 1): ?>
        <a href="?page=1"> <button type="button" class="btn btn-info"><<</button> </a>
        <a href="?page=<?= $currentPageGet - 1; ?>"> <button type="button" class="btn btn-info"><</button> </a>
    <?php endif; ?>

    <button type="button" class="btn btn-info">...</button>

    <?php if ($currentPageGet < $quantityPages): ?>
        <a href="?page=<?= $currentPageGet + 1; ?>"> <button type="button" class="btn btn-info"><?= $currentPageGet + 1; ?></button> </a>

        <?php if ($currentPageGet < $quantityPages - 1): ?>
            <a href="?page=<?= $currentPageGet + 2; ?>"> <button type="button" class="btn btn-info"><?= $currentPageGet + 2; ?></button> </a>
        <?php endif; ?>

        <a href="?page=<?= $currentPageGet + 1; ?>"> <button type="button" class="btn btn-info">></button> </a>
        <a href="?page=<?= $quantityPages; ?>"> <button type="button" class="btn btn-info">>></button> </a>
    <?php endif; ?>
</div>

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



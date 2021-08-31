<?php
define("MOB_IMAGE_PATH", "/i/l2db/mob/");
define("SKILL_IMAGE_PATH", "/i/l2db/skill/");
define("ITEM_IMAGE_PATH", "/i/l2db/item/");
define("MOB_NO_IMAGE_FILE", "noImage.jpg");
define("SKILL_NO_IMAGE_FILE", "0.png");
$paramCount = 0;
$numberOfMidParam = ceil(count($mobParam) / 2);
$numberOfMidSkill = ceil(count($mobSkill) / 2);
?>

<h1><?= $mob->title ?></h1>
<div class="row mb-lg-5">

    <div class="col-6">
        <img class="img-thumbnail" src="<?= MOB_IMAGE_PATH . ($mob->imageFileName !== '' ? $mob->imageFileName : MOB_NO_IMAGE_FILE); ?>">
    </div>

    <div class="col-3 pr-0">
        <table class="table table-bordered table-striped mob-param-table">
            <tbody>
                <?php foreach ($mobParam as $value) : ?>
                    <?php if ($paramCount == $numberOfMidParam) : ?>
                    </tbody>
                </table>
            </div>
            <div class="col-3 pl-0">
                <table class="table table-bordered table-striped mob-param-table">
                    <tbody>
                    <?php endif; ?>
                    <tr>
                        <td style="width: '300px'"><?= $value->param->paramName; ?></td>
                        <td><?= $value->paramValue; ?></td>
                    </tr>
                    <?php $paramCount++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<h2>Умения</h2>

<div class="row mb-lg-5">

    <div class="col-5">

        <?php for ($i = 0; $i < $numberOfMidSkill; $i++) : ?>
            <div class="row border border-warning rounded mob_skill">

                <div class="col-2 pr-0">
                    <img class="img-thumbnail" src="<?= SKILL_IMAGE_PATH . ($mobSkill[$i]->skill->imageFileName !== '' ? $mobSkill[$i]->skill->imageFileName : SKILL_NO_IMAGE_FILE); ?>">
                </div>

                <div class="col-10 pl-0">
                    <b><?= $mobSkill[$i]->skill->title; ?></b>
                    <p><?= $mobSkill[$i]->skill->description; ?></p>
                </div>

            </div>
        <?php endfor; ?>

    </div>

    <div class="col-2">
    </div>

    <div class="col-5">

        <?php for ($i = $numberOfMidSkill; $i < count($mobSkill); $i++) : ?>
            <div class="row border border-warning rounded mob_skill">

                <div class="col-2 pr-0">
                    <img class="img-thumbnail" src="<?= SKILL_IMAGE_PATH . ($mobSkill[$i]->skill->imageFileName !== '' ? $mobSkill[$i]->skill->imageFileName : SKILL_NO_IMAGE_FILE); ?>">
                </div>

                <div class="col-10 pl-0">
                    <b><?= $mobSkill[$i]->skill->title; ?></b>
                    <p><?= $mobSkill[$i]->skill->description; ?></p>
                </div>

            </div>
        <?php endfor; ?>

    </div>

</div>

<div class="row">
    <div class="col-5">
        <h2>Дроп (drop)</h2>
        <?php foreach ($mobDrop as $item) : ?>
            <div class="row border-bottom border-success rounded mob_skill">

                <div class="col-2 pr-0">
                    <img class="img-thumbnail" src="<?= ITEM_IMAGE_PATH . ($item->item->imageFileName !== '' ? $item->item->imageFileName : ITEM_IMAGE_PATH); ?>">
                </div>

                <div class="col-10 pl-0">
                    <b><?= $item->item->title; ?></b>
                    <p><?= $item->description; ?></p>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <div class="col-2">
    </div>

    <div class="col-5">
        <h2>Споил (sweep)</h2>
        <?php foreach ($mobSweep as $item) : ?>
            <div class="row border-bottom border-primary rounded mob_skill">

                <div class="col-2 pr-0">
                    <img class="img-thumbnail" src="<?= ITEM_IMAGE_PATH . ($item->item->imageFileName !== '' ? $item->item->imageFileName : ITEM_IMAGE_PATH); ?>">
                </div>

                <div class="col-10 pl-0">
                    <b><?= $item->item->title; ?></b>
                    <p><?= $item->description; ?></p>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>



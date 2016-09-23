<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тестовое задание';
?>

<?php
$entryDetails = json_decode($searchEntry->details);

?>

<div class="panel panel-default">
    <div class="panel-heading">
        Информация о поисковом запросе #<?= $searchEntry->id ?>
    </div>
    <div class="panel-body">
        Запрос был сделан в: <?= date('d.m.Y h:i:s', strtotime($searchEntry->time)) ?><br />
        Текстовая строка запроса: <?= $searchEntry->byquery ?><br />
        Всего результатов (max=32): <?= count($entryDetails) ?><br />
        <br />
        <?php foreach($entryDetails as $entryDetailsRow) : ?>
            <?= $entryDetailsRow->fullName ?><br />
        <?php endforeach; ?>
    </div>
</div>
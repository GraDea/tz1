<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тестовое задание';
?>

<table class="table table-striped" id="kladr-recent-queries">
    <caption>Последние запросы:</caption>
    <tr>
        <th>Кол-во запросов</th>
        <th>Последний запрос</th>
        <th>Адрес, найденный по этому запросу</th>
    </tr>
    <?php if (is_array($recentQueries) && count($recentQueries) > 0) : ?>
        <?php foreach ($recentQueries as $recentQuery) : ?>
            <tr>
                <td><?= $recentQuery->queryCount ?></td>
                <td><?= $recentQuery->time ?></td>
                <td><a href="<?= \yii\helpers\Url::toRoute(['site/details', 'id' => $recentQuery->id]) ?>"><?= $recentQuery->fulltext ?></a></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <td colspan="3">История запросов пуста...</td>
    <?php endif; ?>
</table>

<?php
$model = new \yii\base\DynamicModel(['address']);
$model->addRule(['address'], 'string', ['max' => 128, 'min' => 3])->addRule(['address'], 'required');
$form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'kladr-search',
    'action' => '/search',
]);
echo $form->field($model, 'address')->textInput();
echo Html::submitButton('Поиск', ['id' => 'kladr-search-submit', 'class' => 'btn btn-info', 'data-loading-text' => 'Loading...']);
$form->end();
?>

<div class="clearfix" style="height:30px;"></div>

<table class="table table-striped" id="kladr-results" style="display: none"></table>

<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Тестовое задание';
?>

<?php
$model = new \yii\base\DynamicModel(['address']);
$model->addRule(['address'], 'string', ['max' => 128, 'min' => 3])->addRule(['address'], 'required');

$form = \yii\bootstrap\ActiveForm::begin([
    'id' => 'kladr-search',
    'action' => '/search',
]);

echo $form->field($model, 'address')->textInput();

echo Html::submitButton('Search', ['id' => 'kladr-search-submit', 'class' => 'btn btn-info', 'data-loading-text' => 'Loading...']);

$form->end();
?>

<div class="clearfix" style="height:30px;"></div>

<table class="table table-striped" id="kladr-results" style="display: none">
    <caption>Search results:</caption>
</table>

<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

$kladrClassPath = Yii::getAlias('@vendor/garakh/kladrapi/Kladr.php');
require_once($kladrClassPath);

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        return $this->render('index');
    }

    public function actionSearch()
    {
        $formInput = Yii::$app->request->post('DynamicModel', false);
        $addressToSearch = $formInput['address'];

        $kladrOutput = false;

        if($addressToSearch) {
            $api = new \Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');
            $query = new \Kladr\Query();
            $query->ContentName = $addressToSearch;
            $query->OneString = TRUE;
            $query->WithParent = false;
            $query->Limit = 5;
            $kladrOutput = $api->QueryToArray($query);
        }

        return $this->renderAjax('search', compact('kladrOutput'));
    }
}

<?php

namespace app\controllers;

use app\models\SearchHistory;
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
        $recentQueries = $this->getRecentQueries();

        return $this->render('index', compact('recentQueries'));
    }

    public function actionSearch()
    {
        $formInput = Yii::$app->request->post('DynamicModel', false);
        $addressToSearch = $formInput['address'];

        $kladrOutput = false;

        if ($addressToSearch) {
            $api = new \Kladr\Api('51dfe5d42fb2b43e3300006e', '86a2c2a06f1b2451a87d05512cc2c3edfdf41969');
            $query = new \Kladr\Query();
            $query->ContentName = $addressToSearch;
            $query->OneString = true;
            $query->WithParent = false;
            $query->Limit = 32;
            $kladrOutput = $api->QueryToArray($query);

            if (is_array($kladrOutput) && count($kladrOutput) > 0) {
                $historyRecord = new SearchHistory();
                $historyRecord->fulltext = $kladrOutput[0]['fullName'];
                $historyRecord->md5text = md5($kladrOutput[0]['fullName']);
                $historyRecord->byquery = $addressToSearch;
                $historyRecord->details = json_encode($kladrOutput);
                $historyRecord->save(false);
                unset($historyRecord);
            }
        }

        $recentQueries = $this->getRecentQueries();
        $bestResult = $kladrOutput[0];

        return $this->renderAjax('search', compact('recentQueries', 'bestResult'));
    }

    public function actionDetails($id)
    {
        $searchEntry = SearchHistory::findOne($id);
        return $this->render('details', compact('searchEntry'));
    }

    private function getRecentQueries()
    {
        return SearchHistory::find()
            // max дата всегда будет с max id
            ->select('MAX(`search_entries`.`id`) AS `id`, `search_entries`.`fulltext`, COUNT(DISTINCT `search_counts`.`time`) as `queryCount`, MAX(`search_entries`.`time`) as `time`')
            ->from('`search_history` AS `search_entries`')
            ->leftJoin('`search_history` AS `search_counts`', '`search_entries`.`md5text` = `search_counts`.`md5text`')
            ->groupBy('`search_entries`.`md5text`')
            ->orderBy('`search_entries`.`time` DESC, `search_entries`.`fulltext` ASC')
            ->limit(5)
            ->all();
    }
}

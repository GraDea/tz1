<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "search_history".
 *
 * @property integer $id
 * @property string $md5text
 * @property string $fulltext
 * @property string $time
 * @property string $byquery
 * @property string $details
 */
class SearchHistory extends \yii\db\ActiveRecord
{
    public $queryCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['md5text', 'fulltext', 'byquery'], 'required'],
            [['time'], 'safe'],
            [['details'], 'string'],
            [['md5text'], 'string', 'max' => 32],
            [['fulltext'], 'string', 'max' => 256],
            [['byquery'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'md5text' => 'Md5text',
            'fulltext' => 'Fulltext',
            'time' => 'Time',
            'byquery' => 'Byquery',
            'details' => 'Details',
        ];
    }
}

<?php

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use app\models\search\HistorySearch;

namespace app\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use app\models\search\HistorySearch;

class ExportJob extends BaseObject implements JobInterface
{
    public $exportType;
    public $params;

    public function execute($queue)
    {
        Yii::info('Export job started', __METHOD__);

        $model = new HistorySearch();
        $dataProvider = $model->search($this->params);
        $filename = 'history-' . date('dmY') . '.' . $this->exportType;
        //$filePath = "/Users/nonename/project/yii2-test/runtime/export/{$filename}";
        //TODO: поправить путь для сохранения файла
        $filePath = Yii::getAlias('@webroot') . "/runtime/export/{$filename}";
        Yii::info('File path: ' . $filePath, __METHOD__);

        $this->exportInChunks($dataProvider, $filePath);

        Yii::info('Export job finished', __METHOD__);
    }

    protected function exportInChunks($dataProvider, $filePath)
    {
        $batchSize = 2000;
        $count = $dataProvider->getTotalCount();
        $batchCount = ceil($count / $batchSize);

        $file = fopen($filePath, 'w');
        Yii::info('File opened: ' . $filePath, __METHOD__);

        // Add headers to the export file
        $headers = [
            'Date', 'User', 'Type', 'Event', 'Message'
        ];
        fputcsv($file, $headers);

        for ($i = 0; $i < $batchCount; $i++) {
            $dataProvider->pagination->page = $i;
            $dataProvider->pagination->pageSize = $batchSize;

            $dataProvider->prepare();
            $models = $dataProvider->getModels();

            foreach ($models as $model) {
                $row = [
                    Yii::$app->formatter->asDatetime($model->ins_ts),
                    isset($model->user) ? $model->user->username : Yii::t('app', 'System'),
                    $model->object,
                    $model->eventText,
                    strip_tags(\app\widgets\HistoryList\helpers\HistoryListHelper::getBodyByModel($model))
                ];
                fputcsv($file, $row);
            }
        }

        fclose($file);
        Yii::info('File closed: ' . $filePath, __METHOD__);
    }
}




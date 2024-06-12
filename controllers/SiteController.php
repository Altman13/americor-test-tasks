<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\search\HistorySearch;
use app\jobs\ExportJob;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionExport($exportType)
    {
        $params = Yii::$app->request->queryParams;

        // Enqueue the export job
        Yii::$app->queue->push(new ExportJob([
            'exportType' => $exportType,
            'params' => $params,
        ]));

        Yii::$app->session->setFlash('success', 'Export process has been started. You will be notified once it\'s completed.');

        return $this->redirect(['index']);
    }
}

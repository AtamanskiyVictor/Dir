<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Dir;
use Yii;
/**
 *
 */
class DirController extends Controller
{

    function actionIndex($path = '.')
    {
        Yii::$app->params['MyStartTime'] = microtime(true);
        $model = new Dir($path);

        return $this->render('dir',[
            'arDirAll'=>$model->getDirAllAr(),
            'arDirInfo'=>$model->getDirInfo()
        ]);
    }

    function actionExport($path = '.')
    {
        $model = new Dir($path);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        return $model->getDirAllAr();
    }
}

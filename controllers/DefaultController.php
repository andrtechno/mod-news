<?php

namespace panix\mod\news\controllers;

use Yii;
use panix\engine\controllers\WebController;
use panix\mod\news\models\News;
use yii\helpers\ArrayHelper;

class DefaultController extends WebController
{
    public function behaviors1()
    {
        $behaviors[] = [
            'class' => 'yii\filters\PageCache',
            'only' => ['view'],
            'duration' => 86400 * 30,
            'variations' => [
                //Yii::$app->language,
                Yii::$app->request->get('slug')
            ],
            'dependency' => [
                'class' => 'yii\caching\DbDependency',
                'sql' => 'SELECT MAX(updated_at) FROM ' . News::tableName(),
            ]
        ];
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    public function actionView($slug)
    {
        $layouts = [
            "@theme/modules/news/views/default/html",
            "@news/views/default/html",
        ];

        foreach ($layouts as $layout) {
            if (file_exists(Yii::getAlias($layout) . DIRECTORY_SEPARATOR . $slug . '.' . $this->view->defaultExtension)) {
                return $this->render($layout . '/' . $slug, []);
            }
        }

        $model = News::find()
            ->where(['slug' => $slug])
            ->published()
           // ->cache(3200, new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM ' . Pages::tableName()]))
            ->one();


        if (!$model) {
            $this->error404();
        }
        $this->pageName = $model->name;
        $this->breadcrumbs = [$this->pageName];
        $this->view->title = $this->pageName;
        return $this->render('view', ['model' => $model]);
    }

}

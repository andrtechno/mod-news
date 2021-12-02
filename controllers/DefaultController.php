<?php

namespace panix\mod\news\controllers;

use panix\engine\data\ActiveDataProvider;
use panix\mod\news\models\NewsCategory;
use Yii;
use panix\engine\controllers\WebController;
use panix\mod\news\models\News;
use panix\mod\news\models\NewsSearch;
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

    public function actionIndex()
    {
        $this->pageName = Yii::t($this->module->id . '/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'][] = $this->pageName;


        // if(Yii::$app->request->get('category')){

        //    $query = NewsCategory::find()->published();
        // }else{
        $query = News::find()->published()->sort();
        if (Yii::$app->request->get('category')) {

            $category = NewsCategory::find()
                ->published()
                ->where(['slug' => Yii::$app->request->get('category')])
                ->one();
            if (!$category) {
                $this->error404();
            }
            $query->andWhere(['category_id' => $category->id]);
        }
        if (Yii::$app->request->get('tag')) {
            $query->anyTagValues(Yii::$app->request->get('tag'));
        }
        // }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($slug)
    {
        $this->dataModel = News::find()
            ->where(['slug' => $slug])
            ->published()
            // ->cache(3200, new \yii\caching\DbDependency(['sql' => 'SELECT MAX(updated_at) FROM ' . News::tableName()]))
            ->one();


        if (!$this->dataModel) {
            $this->error404();
        }
        $this->dataModel->updateCounters(['views' => 1]);
        $this->view->setModel($this->dataModel);
        $this->pageName = $this->dataModel->name;
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t($this->module->id . '/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        if ($this->module->enableCategory) {
            if ($this->dataModel->category_id) {
                $this->view->params['breadcrumbs'][] = [
                    'label' => $this->dataModel->category->name,
                    'url' => $this->dataModel->category->getUrl()
                ];
            }
        }
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $this->view->title = $this->pageName;
        return $this->render('view', ['model' => $this->dataModel]);
    }

}

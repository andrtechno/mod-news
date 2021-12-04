<?php

namespace panix\mod\news\controllers\admin;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use panix\engine\Html;
use panix\mod\news\models\News;
use panix\mod\news\models\search\NewsSearch;
use panix\engine\controllers\AdminController;


class DefaultController extends AdminController
{

    public function actions()
    {
        return [
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => News::class,
            ],
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => News::class,
            ],
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => News::class,
            ],
            'delete-file' => [
                'class' => 'panix\engine\actions\DeleteFileAction',
                'modelClass' => News::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t($this->module->id.'/default', 'MODULE_NAME');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t($this->module->id.'/default', 'BTN_CREATE'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];

        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {

        $model = News::findModel($id);
        $this->pageName = Yii::t($this->module->id.'/default', 'BTN_CREATE');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") ||  Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t($this->module->id.'/default', 'BTN_CREATE'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t($this->module->id.'/default', 'MODULE_NAME'),
            'url' => ['index']
        ];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $result = [];
        $result['success'] = false;
        $isNew = $model->isNewRecord;
        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            //if (Yii::$app->request->isAjax) {
            //    Yii::$app->response->format = Response::FORMAT_JSON;
            //    return ActiveForm::validate($model);
            //}

            if ($model->validate()) {
                $model->save();

                $json['success'] = false;
                if (Yii::$app->request->isAjax && Yii::$app->request->post('ajax')) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $json['success'] = true;
                    $json['message'] = Yii::t('app/default','SUCCESS_UPDATE');
                    return $json;
                }

                return $this->redirectPage($isNew, $post);
            } else {
                // print_r($model->getErrors());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function getAddonsMenu()
    {
        $items[] = [
            'label' => Yii::t('app/default', 'SETTINGS'),
            'url' => ["/admin/{$this->module->id}/settings/index"],
            'icon' => Html::icon('settings'),
        ];
        if (Yii::$app->getModule($this->module->id)->enableCategory) {
            $items[] = [
                'label' => Yii::t('work/default', 'CATEGORIES'),
                'url' => ["/admin/{$this->module->id}/categories/index"],
                'icon' => Html::icon('folder'),
            ];
        }
        return $items;
    }

    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}

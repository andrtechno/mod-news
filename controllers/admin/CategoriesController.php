<?php

namespace panix\mod\news\controllers\admin;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use panix\engine\Html;
use panix\mod\news\models\NewsCategory;
use panix\mod\news\models\search\NewsCategorySearch;
use panix\engine\controllers\AdminController;


class CategoriesController extends AdminController
{

    public function actions()
    {
        return [
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => NewsCategory::class,
            ],
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => NewsCategory::class,
            ],
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => NewsCategory::class,
            ],
            'delete-file' => [
                'class' => 'panix\engine\actions\DeleteFileAction',
                'modelClass' => NewsCategory::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('news/default', 'CATEGORIES');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t('news/default', 'BTN_CREATE_CATEGORY'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('news/default', 'MODULE_NAME'),
            'url' => ['/news/admin/default/index']
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new NewsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {

        $model = NewsCategory::findModel($id);
        $this->pageName = Yii::t('news/default', 'BTN_CREATE_CATEGORY');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") ||  Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t('news/default', 'BTN_CREATE_CATEGORY'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('news/default', 'MODULE_NAME'),
            'url' => ['/news/admin/default/index']
        ];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('news/default', 'CATEGORIES'),
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
        return [
            [
                'label' => Yii::t('app/default', 'SETTINGS'),
                'url' => ['/admin/news/settings/index'],
                'icon' => Html::icon('settings'),
            ],
        ];
    }

    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}

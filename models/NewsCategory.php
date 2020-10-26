<?php

namespace panix\mod\news\models;

use panix\mod\news\models\query\NewsCategoryQuery;
use panix\mod\news\models\search\NewsCategorySearch;
use Yii;
use panix\engine\db\ActiveRecord;

/**
 * This is the model class for table "news_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $slug
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewsCategory extends ActiveRecord
{

    const route = '/admin/news/default';
    const MODULE_ID = 'news';
    public $translationClass = NewsCategoryTranslate::class;


    public static function find()
    {
        return new NewsCategoryQuery(get_called_class());
    }

    public function getGridColumns()
    {
        return [
            'id' => [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'name',
                'contentOptions' => ['class' => 'text-left'],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new NewsCategorySearch(),
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new NewsCategorySearch(),
                    'attribute' => 'updated_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d D Y H:i:s');
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
                [
                    'class' => \panix\engine\grid\sortable\Column::class,
                    'url' => ['/admin/news/category/sortable']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['text'], 'string'],
            [['name', 'slug'], 'trim'],
            ['slug', '\panix\engine\validators\UrlValidator', 'attributeCompare' => 'name'],
            ['slug', 'match',
                'pattern' => '/^([a-z0-9-])+$/i',
                'message' => Yii::t('app/default', 'PATTERN_URL')
            ],
            [['updated_at', 'created_at'], 'safe'],
            [['text', 'image'], 'default'],
        ];
    }

    public function getUrl()
    {
        return ['/news/default/index', 'category' => $this->slug];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    public function behaviors()
    {
        $b = [];
        if (Yii::$app->getModule('seo'))
            $b['seo'] = [
                'class' => '\panix\mod\seo\components\SeoBehavior',
                'url' => $this->getUrl()
            ];

        $b['uploadFile'] = [
            'class' => 'panix\engine\behaviors\UploadFileBehavior',
            'files' => [
                'image' => '@uploads/news_category',
            ],
            'options' => [
                'watermark' => false
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($b, parent::behaviors());
    }

}

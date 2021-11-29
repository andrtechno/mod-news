<?php

namespace panix\mod\news\models;


use panix\engine\CMS;
use Yii;
use panix\engine\db\ActiveRecord;
use panix\engine\taggable\Tag;
use panix\engine\taggable\TagAssign;
use panix\mod\news\models\query\NewsQuery;
use panix\mod\news\models\search\NewsSearch;
use panix\mod\user\models\User;
use yii\caching\DbDependency;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $slug
 * @property integer $views
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $category_id
 * @property NewsCategory $category
 * @property User $user
 * @property Tag $tags
 */
class News extends ActiveRecord
{

    const route = '/admin/news/default';
    const MODULE_ID = 'news';
    public $translationClass = NewsTranslate::class;

    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function getGridColumns()
    {

        $columns = [];
        $columns['id'] = [
            'attribute' => 'id',
            'contentOptions' => ['class' => 'text-center'],
        ];

        $columns['name'] = [
            'attribute' => 'name',
            'contentOptions' => ['class' => 'text-left'],
        ];
        if (Yii::$app->getModule(self::MODULE_ID)->enableCategory) {
            $columns['category_id'] = [
                'attribute' => 'category_id',
                'filter' => ArrayHelper::map(NewsCategory::find()->joinWith('translations')
                    //  ->cache(3200, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM ' . NewsCategory::tableName()]))
                    ->addOrderBy(['name' => SORT_ASC])
                    ->all(), 'id', 'name'),
                'filterInputOptions' => ['class' => 'form-control', 'prompt' => html_entity_decode('&mdash; категория &mdash;')],
                'value' => function ($model) {
                    return ($model->category_id) ? $model->category->name : NULL;
                }
            ];

        }
        $columns['views'] = [
            'attribute' => 'views',
            'contentOptions' => ['class' => 'text-center'],
        ];

        $columns['created_at'] = [
            'attribute' => 'created_at',
            'format' => 'raw',
            'filter' => \yii\jui\DatePicker::widget([
                'model' => new NewsSearch(),
                'attribute' => 'created_at',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]),
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
            }
        ];
        $columns['updated_at'] = [
            'attribute' => 'updated_at',
            'format' => 'raw',
            'filter' => \yii\jui\DatePicker::widget([
                'model' => new NewsSearch(),
                'attribute' => 'updated_at',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]),
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) {
                return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d D Y H:i:s');
            }
        ];
        $columns['DEFAULT_CONTROL'] = [
            'class' => 'panix\engine\grid\columns\ActionColumn',
        ];
        $columns['DEFAULT_COLUMNS'] = [
            ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            [
                'class' => \panix\engine\grid\sortable\Column::class,
                'url' => ['/admin/news/default/sortable']
            ],
        ];
        return $columns;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $rules = [];
        $rules[] = ['tagValues', 'safe'];
        $rules[] = [['name', 'short_description', 'slug'], 'required'];
        if (Yii::$app->getModule('news')->enableCategory) {
            $rules[] = [['category_id'], 'required'];
        }
        $rules[] = [['name', 'slug'], 'string', 'max' => 255];
        $rules[] = [['full_description'], 'string'];
        $rules[] = [['name', 'slug'], 'trim'];
        $rules[] = ['slug', '\panix\engine\validators\UrlValidator', 'attributeCompare' => 'name'];
        $rules[] = ['slug', 'match',
            'pattern' => '/^([a-z0-9-])+$/i',
            'message' => Yii::t('app/default', 'PATTERN_URL')
        ];
        $rules[] = [['updated_at', 'created_at'], 'safe'];
        $rules[] = [['short_description', 'image'], 'default'];

        return $rules;
    }

    public function getUrl($category = null)
    {
        if (Yii::$app->getModule('news')->enableCategory) {
            if($this->category_id){
                return ['/news/default/view', 'category' => $this->category->slug, 'slug' => $this->slug];
            }
        }
        return ['/news/default/view', 'slug' => $this->slug];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable(TagAssign::tableName(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'category_id']);
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'tagValues' => self::t('TAGVALUES'),
        ], parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $b = [];
        if (Yii::$app->getModule('seo'))
            $b['seo'] = [
                'class' => '\panix\mod\seo\components\SeoBehavior',
                'url' => $this->getUrl()
            ];

        if (Yii::$app->getModule('sitemap')) {
            $b['sitemap'] = [
                'class' => '\panix\mod\sitemap\behaviors\SitemapBehavior',
                //'batchSize' => 100,
                'groupName' => 'Новости',
                'scope' => function ($model) {
                    /** @var \yii\db\ActiveQuery $model */
                    //$model->select(['slug', 'updated_at','name']);
                    $model->where(['switch' => 1]);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => $model->getUrl(),
                        'lastmod' => $model->updated_at,
                        'name' => $model->name,
                        'changefreq' => \panix\mod\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                        'priority' => 0.1
                    ];
                }
            ];
        }

        $b['taggable'] = [
            'class' => '\panix\engine\taggable\TaggableBehavior',
            // 'tagValuesAsArray' => false,
            // 'tagRelation' => 'tags',
            // 'tagValueAttribute' => 'name',
            // 'tagFrequencyAttribute' => 'frequency',
        ];

        if (Yii::$app->hasModule('comments')) {
            $b['commentBehavior'] = [
                'class' => 'panix\mod\comments\components\CommentBehavior',
                'owner_title' => 'name',

            ];
        }


        $b['uploadFile'] = [
            'class' => 'panix\engine\behaviors\UploadFileBehavior',
            'files' => [
                'image' => '@uploads/news',
            ],
            'options' => [
                'watermark' => false
            ]
        ];

        return \yii\helpers\ArrayHelper::merge($b, parent::behaviors());
    }

    public function beforeSave($insert)
    {
        $this->created_at = strtotime($this->created_at);
        return parent::beforeSave($insert);
    }
}

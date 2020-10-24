<?php

namespace panix\mod\news;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'newspaper';

    public function bootstrap($app)
    {

        $groupUrlRule = new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => [
                '<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>' => 'default/view',
                '<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>' => 'default/view',
                '<slug:[0-9a-zA-Z_\-]+>' => 'default/view',
                'page/<page:\d+>/per-page/<per-page:\d+>' => 'default/index',
                'page/<page:\d+>' => 'default/index',
                'tag/<tag:[\w\d\s]+>' => 'default/index',
                '' => 'default/index',
            ],
        ]);
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('news/default', 'MODULE_NAME'),
                        'url' => ['/admin/news'],
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can('/news/admin/default/index') || Yii::$app->user->can('/news/admin/default/*')
                    ],
                ],
            ],
        ];
    }


    public function getInfo()
    {
        return [
            'label' => Yii::t('news/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('news/default', 'MODULE_DESC'),
            'url' => ['/admin/news'],
        ];
    }

}

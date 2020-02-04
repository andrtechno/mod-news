<?php

namespace panix\mod\news;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'newspaper';

    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'news/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>' => 'news/default/view',
                'news/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>' => 'news/default/view',
                'news/<slug:[0-9a-zA-Z_\-]+>' => 'news/default/view',

            ],
            true
        );
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

<?php

namespace panix\mod\news;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;
use panix\engine\web\GroupUrlRule;

/**
 * Class Module
 *
 * @property boolean $enableCategory
 *
 * @package panix\mod\news
 */
class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'newspaper';
    public $enableCategory = true;

    public function bootstrap($app)
    {

        /*$groupUrlRule = new GroupUrlRule([
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
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);*/


        $rules = [];
        if ($this->enableCategory) {
            $rules['<category:[0-9a-zA-Z_\-]+>/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>'] = 'default/view';
            $rules['<category:[0-9a-zA-Z_\-]+>/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>'] = 'default/view';
            $rules['<category:[0-9a-zA-Z_\-]+>/<slug:[0-9a-zA-Z_\-]+>'] = 'default/view';
            $rules['<category:[0-9a-zA-Z_\-]+>/page/<page:\d+>'] = 'default/index';
            $rules['<category:[0-9a-zA-Z_\-]+>'] = 'default/index';

        } else {
            $rules['<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>'] = 'default/view';
            $rules['<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>'] = 'default/view';
            $rules['<slug:[0-9a-zA-Z_\-]+>'] = 'default/view';
        }
        $rules['tag/<tag:[\w\d\s]+>'] = 'default/index';
        $rules[''] = 'default/index';
        $groupUrlRule = new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => $rules,
        ]);
        $app->getUrlManager()->addRules($groupUrlRule->rules, false);
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t($this->id . '/default', 'MODULE_NAME'),
                        'url' => ['/admin/' . $this->id],
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can("/{$this->id}/admin/default/index") || Yii::$app->user->can("/{$this->id}/admin/default/*")
                    ],
                ],
            ],
        ];
    }


    public function getInfo()
    {
        return [
            'label' => Yii::t($this->id . '/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t($this->id . '/default', 'MODULE_DESC'),
            'url' => ['/admin/' . $this->id],
        ];
    }

}

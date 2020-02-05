<?php

namespace panix\mod\news\models;

use panix\engine\SettingsModel;

/**
 * Class SettingsForm
 * @package panix\mod\news\models
 */
class SettingsForm extends SettingsModel
{

    protected $module = 'news';
    public static $category = 'news';

    public $pagenum;

    public function rules()
    {
        return [
            ['pagenum', 'required'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'pagenum' => 10,
        ];
    }
}

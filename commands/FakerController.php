<?php

namespace panix\mod\news\commands;

use panix\engine\CMS;
use panix\mod\news\models\News;
use yii\console\Controller;
use Yii;

class FakerController extends Controller
{
    public function actionIndex($count = 10)
    {

        $faker = \Faker\Factory::create('en_US');



        $data = [];
        for ($i = 0; $i <= $count; $i++) {
            $text = $faker->sentence(rand(100, 500), true);
            $data[] = [
                'user_id' => 1,
                'name' => $faker->sentence(10, true),
                'slug' => CMS::slug($faker->sentence(10, true)),
                'short_description' => $text,
                'full_description' => $text
            ];
            $model = new News();
            $model->detachBehavior('uploadFile');
            $model->user_id = 1;
            $model->category_id = rand(1,2);
            $model->name = $faker->sentence(10, true);
            $model->slug = CMS::slug($model->name);
            $model->image = CMS::fakeImage(Yii::getAlias('@uploads/news'),'640x480','news');
            $model->short_description = $faker->sentences(rand(20, 50), true);
            $model->full_description = '<blockquote>'.$faker->sentences(rand(20, 50), true).'</blockquote>'.$faker->sentences(rand(500, 1000), true);
            //$news->full_description = Html::img($faker->imageUrl(640, 480, 'Testing', false, 'by CMS')) . $faker->sentences(rand(500, 1000), false);
            $model->save(false);
            echo 'Add News: ' . $model->name . PHP_EOL;
        }


        // print_r(array_keys($data,false));
        //   Yii::$app->db->createCommand()->batchInsert(News::tableName(), ['user_id', 'name', 'slug', 'short_description', 'full_description'], $data)->execute();
    }

    public function actionDel()
    {
        echo 'Truncate News' . PHP_EOL;
        $files = glob(Yii::getAlias('@uploads/news/*'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        News::deleteAll();

    }
}
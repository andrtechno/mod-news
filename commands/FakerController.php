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
            $news = new News();
            $news->detachBehavior('uploadFile');
            $news->user_id = 1;
            $news->category_id = rand(1,2);
            $news->name = $faker->sentence(10, true);
            $news->slug = CMS::slug($news->name);
            $news->image = $faker->image(Yii::getAlias('@uploads/news'), 640, 480, null, false);
            $news->short_description = $faker->sentences(rand(20, 50), true);
            $news->full_description = '<blockquote>'.$faker->sentences(rand(20, 50), true).'</blockquote>'.$faker->sentences(rand(500, 1000), true);
            //$news->full_description = Html::img($faker->imageUrl(640, 480, 'Testing', false, 'by CMS')) . $faker->sentences(rand(500, 1000), false);
            $news->save(false);
            echo 'Add News: ' . $news->name . PHP_EOL;
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
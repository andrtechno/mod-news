<?php
use panix\ext\tinymce\TinyMce;

/**
 * @var \panix\engine\bootstrap\ActiveForm $form
 * @var \panix\mod\news\models\News $model
 */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
<?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>
<?=
$form->field($model, 'short_description')->widget(TinyMce::class, [
    'options' => ['rows' => 6],
]);
?>
<?=
$form->field($model, 'full_description')->widget(TinyMce::class, [
    'options' => ['rows' => 6],
]);
?>
<?= $form->field($model, 'image', [
    'parts' => [
        '{buttons}' => $model->getFileHtmlButton('image')
    ],
    'template' => '<div class="col-sm-4 col-lg-2">{label}</div>{beginWrapper}{input}{buttons}{error}{hint}{endWrapper}'
])->fileInput() ?>

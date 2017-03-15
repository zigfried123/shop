<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$flash = Yii::$app->getSession()->getFlash('success_category');

echo $flash;

?>

<h2 class="text-center">Продукты</h2>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?php $tree = $model->getTree(); ?>

    <?= $form->field($model, 'cat_id')->label("Выбрать категорию")->dropDownList($tree); ?>
	
	<?= $form->field($model, 'name')->label("Добавить продукт"); ?>
	
	<?= $form->field($model, 'img')->label("Добавить изображение")->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
	
	

<?php ActiveForm::end(); ?>



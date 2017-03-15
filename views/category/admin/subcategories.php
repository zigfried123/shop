<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$flash = Yii::$app->getSession()->getFlash('success_category');

echo $flash;

?>

<h2 class="text-center">Подкатегории</h2>


<?php $form = ActiveForm::begin(); ?>

<?php $tree = $model->getTree(); ?>

    <?= $form->field($model, 'id')->label("Выбрать категорию")->dropDownList($tree); ?>
	
	<?= $form->field($model, 'name')->label("Добавить категорию"); ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
	
	

<?php ActiveForm::end(); ?>



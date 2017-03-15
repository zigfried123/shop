<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$flash = Yii::$app->getSession()->getFlash('success_roots');

echo $flash;

?>

<h2 class="text-center">Категории</h2>


<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
	
	

<?php ActiveForm::end(); ?>






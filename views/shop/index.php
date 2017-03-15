<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\Session;
?>
<?php
$session = new Session;
			$session->open();
?>

 <?php
echo dirname(Yii::$app->basePath);
?>

  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'login') ?>

    <?= $form->field($model, 'pass') ?>
	
	

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-but']) ?>
    </div>
	
	
	

	
	
	

<?php ActiveForm::end(); ?>



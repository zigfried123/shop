<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.2/angular.min.js"></script>

<div ng-app>



Ваше имя: {{name}}






<?php $form = ActiveForm::begin([
    'class' => 'dsf',
    
]); ?>

    <?= $form->field($model, 'name')->textInput(['ng-model' => 'name','placeholder'=>"Введите свое имя"]); ?>

  

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
	
	
	
	
	
	
	

<?php ActiveForm::end(); ?>








</div>





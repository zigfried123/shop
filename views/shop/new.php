<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($models, 'logout') ?>

   
	
	

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

?php ActiveForm::end(); ?>
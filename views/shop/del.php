

<?php $form = ActiveForm::begin(); ?>



 <?= $form->field($model, 'delete') ?>
 
 
 <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
 
 <?php ActiveForm::end(); ?>



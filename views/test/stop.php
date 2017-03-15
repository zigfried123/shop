<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


echo "Игра завершена<br>";

if(isset($name)){
echo "Ваше имя: ".$name."<br>";
}

if(isset($score)){
	echo "Вы набрали ". $score." очков<br>";
}else{
	echo "Вы набрали 0 очков<br>";
}



?>




<?php $form = ActiveForm::begin(); ?>

    
    <div class="form-group">
        <?= Html::submitButton('New Game', ['class' => 'btn btn-primary','name' => 'newgame']); ?>
    </div>
	
	
	
	
	
	
	

<?php ActiveForm::end(); ?>




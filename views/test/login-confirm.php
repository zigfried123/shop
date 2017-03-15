<?php
use yii\helpers\Html;
use yii\helpers\Url; 
use yii\web\Session;
use yii\widgets\ActiveForm;

if(isset($name)){
	echo "Вы зашли под именем: ".$name."<br>";
}


$session = Yii::$app->session;


if(isset($arr) && is_array($arr)){
	
	echo $arr["need"]."<br>";
	
	foreach($arr["arr"] as $key=>$val){
		
		if(!isset($session["try"])){
			echo $key.". ".Html::a($val, Url::to(["/test"]), ["data"=>['method'=>"POST", 'params' => ['try' => 2, 'name' => $val]]])."<br>";
		}else{		
			if($session["try"]==2){
				echo $key.". ".Html::a($val, Url::to(["/test"]), ["data"=>['method'=>"POST", 'params' => ['try' => 3, 'name' => $val]]])."<br>";
			}else if($session["try"]==3){
				echo $key.". ".Html::a($val, Url::to(["/test"]), ["data"=>['method'=>"POST", 'params' => ['stop' => true, 'name' => $val]]])."<br>";
			}
		}		
		
	}
}

if(isset($session["try"])){
	if($session["try"]==2){
		echo "У вас еще 2 попытки"."<br>";
	}else if($session["try"]==3){
		echo "У вас еще 1 попытка"."<br>";
	}
}

if(isset($session["score"])){
	
	echo "Количество очков: ".$session["score"]."<br>";
}else{
	echo "Количество очков: 0<br>";
}


if(isset($session["wrong"])){
	//var_dump($session["wrong"]);
}


if(isset($session["json_full"])){
	//var_dump($session["json_full"]);
}



?>

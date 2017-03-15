<?php

namespace app\controllers\test;

use Yii;
use yii\web\Controller;
use app\models\test\TestModel;


class TestController extends Controller
{
	

	public function actionIndex(){
		
		//$model = new TestModel();
		
		
		
		if(isset($_POST["TestModel"])){
			

		}else{
			return $this->render('test/index',["model"=>$model]);
		}	
	}
}
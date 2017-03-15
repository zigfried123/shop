<?php

namespace app\controllers;


use Yii;

use yii\web\Controller;

use app\models\LogoutForm;


class LogoutController extends Controller
{
    public function actionLogout()
    {
	
		$models = new LogoutForm;
		
	//$model->setScenario('login');
		
		
		if($models->load($_POST) && $models->validate()){
			
			//$shop = new ShopDb;
				
			return $this->render('New', ['model' => $model]);
		}else{
			
		}
    }
}


?>
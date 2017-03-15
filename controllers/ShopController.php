<?php

namespace app\controllers;


use Yii;

use yii\web\Controller;

use app\models\ShopForm;



use yii\web\Session;


class ShopController extends Controller
{
	public $layout = 'main';
	
    public function actionIndex()
    {
		
	
		$model = new ShopForm;
		
	//$model->setScenario('login');
		
		
		
		
		if(isset($_POST["login-but"])){
			
			
			$model->attributes = $_POST["ShopForm"];
			
			if($model->validate()){
			
			$model->save();
			
			//$shop = new ShopDb;
			
			
			
			
			return $this->refresh();
			
			}else{
				return $this->render('Index', ['model' => $model]);
			}
				
			
		}else{
			
			
			
			return $this->render('Index', ['model' => $model]);
			
			
			
		}
		
		

		
		
		
		
		
		
    }
	
	
	public function actionPage()
	{
		return $this->render("page", ['page' => 123]);
	}
	
}



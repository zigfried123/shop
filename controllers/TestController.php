<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\test\TestModel;
use app\models\test\RatingModel;
use app\models\test\WrongModel;
use yii\web\Session;
use yii\helpers\VarDumper;
use yii\helpers\Url; 

class TestController extends Controller
{

	public function actionIndex(){
		
		$model = new TestModel();
		
		$session = Yii::$app->session;
	
		//если отправлена форма входа
		if(isset($_POST["TestModel"])){
			
			$session["name"] = $_POST["TestModel"]["name"];	
			
			$arr = $model->getJson();
			
			$session["arr"] = $arr;
			
		}
		
		//если вход выполнен	
		if(isset($session["name"])){
			
			if(isset($_POST["try"]) || isset($_POST["stop"])){
					
				$need = $session["arr"]["need"];
				$need_flip = $session["arr"]["need_flip"];
				
				//если ответ неправильный
				if($_POST["name"] != $need && $_POST["name"] != $need_flip){
				
					if(isset($_POST["try"])){
						$arr = $session["arr"];
			
						//запись попыток в сессию
						if($_POST["try"]==2){
							$session["try"] = 2;
						}else if($_POST["try"]==3){
							$session["try"] = 3;
						}
					//если сделано 3 ошибки, формируется новый массив	
					}else if(isset($_POST["stop"])){
						$arr = $model->getJson(true);
						$stop = true;
					}
					
					//в бд записывается массив неправильных ответов
					$wrong = new WrongModel();
					$wrong->question = $need;
					$wrong->answer = $_POST["name"];
					$wrong->save();
				//если ответ правильный
				}else if($_POST["name"] == $need || $_POST["name"] == $need_flip){
					
					$arr = $model->getJson();
					$session["arr"] = $arr;
					
					//если правильный ответ добавляется очко
					if(!isset($session["score"])){
						$session["score"] = 1;
					}else{
						$score = $session["score"];
						$score++;
						$session["score"] = $score;
					}
				
					unset($session["try"]);
				
					
					if(empty($session["json_full"])){
						$stop = true;
					}
					
				}
				
			}else{
			
				$arr = $session["arr"];
	
			}
			
			//если вопросы закончились или сделано 3 ошибки - удаляются переменные сессии
			if(isset($stop)){
				
				$name = $session["name"];
				unset($session["name"]);
				$score = $session["score"];
				unset($session["score"]);
				unset($session["try"]);
				unset($session["json_full"]);
				//запись в бд игрока и количество очков
				$rating = new RatingModel();
				$rating->user = $name;
				if($score>0){
					$rating->score = $score;
				}else{
					$rating->score = 0;
				}
				$rating->save();
					
				return $this->render('stop',["score"=>$score, "arr"=>$arr, "name"=>$name]);
			
			}
		
			return $this->render('login-confirm',["name"=>$session["name"],"arr"=>$arr]);
			
		//если вход не выполнен или новая игра	
		}else if(!isset($session["name"])){
			return $this->render('index',["model"=>$model]);
		}
		
		
	}

}
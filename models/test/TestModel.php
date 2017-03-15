<?php

namespace app\models\test;

use Yii;

use yii\base\Model;

use yii\helpers\VarDumper;

use yii\web\Session;



class TestModel extends Model
{
	public $name;
	
	public $variants = ["a"=>"","b"=>"","c"=>"","d"=>""];
	
	public $json = '{
	"apple": "яблоко",
	"peach": "персик",
	"orange": "апельсин",
	"grape": "виноград",
	"lemon": "лимон",
	"pineapple": "ананас",
	"watermelon": "арбуз",
	"coconut": "кокос",
	"banana": "банан",
	"pomelo": "помело",
	"strawberry": "клубника",
	"raspberry": "малина",
	"melon": "дыня",
	"apricot": "абрикос",
	"mango": "манго",
	"pear": "груша",
	"pomegranate": "гранат",
	"cherry": "вишня"
	}';

	public $array_random = ["array","array_flip"];

	
	public function rules(){
		return [
		["name","required"]
		];
	}
	
	public function getJson($stop=false){
		
		$session = Yii::$app->session;
		
		$json_decode = json_decode($this->json,true);
		
		$json_flip = array_flip($json_decode);
		
		
		if(empty($session["json_full"]) || $stop==true){
			
			$json_full = json_decode($this->json,true);
			
			$session["json_full"] = $json_full;
			
		}else{
			
			$json_full = $session["json_full"];
			
		}
		
		if(!empty($json_full)){
			
			if($this->array_random[array_rand($this->array_random)] == "array"){
				$data = $this->getVariants($json_decode,$json_full);
			}else{
				
				$json_full_flip = array_flip($json_full);
				
				$data = $this->getVariants($json_flip,$json_full_flip);
				
			}
			
			
			if(!isset($_POST["TestModel"])){
		
				unset($json_full[$data["need"]]);
						
				unset($json_full[$data["need_flip"]]);
				
				
				$session["json_full"] = $json_full;
			
			}
			
			return $data;
			
		}
			
		
	} 
	
	public function getVariants($json,$json_full){
		$need = array_rand($json_full);
		$need_flip = $json_full[$need];
		foreach($this->variants as $key=>$val){
			if($key=="a"){
			$arr[$key] = $json_full[$need];
			unset($json_full[$need]);
			unset($json_full[$need_flip]);
			unset($json[$need]);
			$json = array_flip($json); 
			}else{
			$arr[$key] = array_rand($json);
			unset($json[$arr[$key]]);
			}
		}
		
		$vals = array_values($arr);
		
		shuffle($vals);
		
		$i=0;
		foreach($arr as $key=>&$val){
			$val = $vals[$i++];
		}
		
		$data = ["arr"=>$arr, "need"=>$need, "need_flip"=>$need_flip];
		
		return $data;
		
		
	}
	
	
}


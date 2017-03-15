<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?> 




	<?php
	
	$arr1 = [1,2,3];
	
	$arr2 = [4,5,3];
	
	
	$arr["name"][] = [$arr1];
	
	$arr["name"][] = [array_intersect($arr2,$arr1),"hgh"];
	
	
	//pre($arr);
	
	

	
	
	
	
	
	$url="basic/web/category";
	
if(isset($tree["breads"])){
//pre($tree["breads"]);
}
	
	
	
	if(!empty(isset($tree["breads"][2]))){
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки 
			'url' => ["/category"."/".$tree["breads"][0]["alias"]."/"] // сама ссылка
						
		];
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][1]["name"]), // название ссылки 
			'url' => ["/category"."/".$tree["breads"][0]["alias"]."/".$tree["breads"][1]["alias"]."/"] // сама ссылка
						
		];
		
		
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][2]["name"]), // название ссылки 
			
						
		];
	
	
		$this->params['breadcrumbs'][] = false;
	
	
	}else if(!empty($tree["breads"][1])){
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки 
			'url' => ["/category"."/".$tree["breads"][0]["alias"]."/"] // сама ссылка
						
		];
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][1]["name"]), // название ссылки 
			
						
		];
		
		$this->params['breadcrumbs'][] = false;
		
	}else if(!empty($tree["breads"][0])){
		
		$this->params['breadcrumbs'][] = [
						
			'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки 
			
						
		];
		
		
		$this->params['breadcrumbs'][] = false;
		
		
		
	}else{
		
		$this->params['breadcrumbs'][] = false;
	}
	
	
	
	/*
	
	if(isset($current_url)){
		
		
		
		$bread_url = str_replace("/".$url."/","",$current_url);
		
		
		
		if($bread_url!="index"){
			$breads = explode("/",$bread_url);
			$breads = explode("?",$breads[0]);
			//var_dump($breads[0]);
		}else{
			$breads = null;
			$this->params['breadcrumbs'][] = false;
		}
	}
	
	if(isset($breads) && count($breads>=1)){
		
		
	
			function make_url(&$bread_url,$count,$i,$breads,&$bread_url_arr){
				if($i<$count-1){
					
					$i++;
					$bread_url.=$breads[$i]."/";
					pre($bread_url);
					$bread_url_arr[] = $bread_url;
					make_url($bread_url,$count,$i,$breads,$bread_url_arr);
				}
			}
			
			$bread_url = "/category/".$breads[0]."/";
			
			
		
			$bread_url_arr[] = $bread_url;
	
			make_url($bread_url,count($breads),0,$breads,$bread_url_arr);
			
			
			foreach($breads as $key=>$val){
				
				
				
				if($val != end($breads)){
	
					$this->params['breadcrumbs'][] = [
					
					'label' => ucfirst($val), // название ссылки 
					'url' => [Url::to($bread_url_arr[$key])] // сама ссылка
					
					];
					
					
					
					
			
				}else{
					$this->params['breadcrumbs'][] = [
					
					'label' => ucfirst($val), // название ссылки 
					
					
					];
					
					
					$this->params['breadcrumbs'][] = [
					
					"label" => "",
					
					];
					
					
				}
			
			}
			
			
					
	}	

	
	
	
	
	*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if(isset($tree["with_parents2"])){
		pre($tree["with_parents2"]);
		foreach($tree["with_parents2"] as $key=>$val){
			
			if(is_object($val)){
				echo $val->name;
			}if(is_array($val)){
				foreach($val as $key2=>$val2){
					if(is_object($val2)){
						echo $val2->name."<br>";
					}else if(is_array($val2->name)){
						pre($val2->name);
					}
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	function pre($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	
	


	
	//echo Html::encode("<dsfdgfdg");
	
	//var_dump($arr5["dgf"]);
	

/*

function test(&$arr,$i,$lvl,&$path){
	
	
	
	if($i<=$lvl){
		
		$i++;
		
		
		$path.= Html::encode("<name".$i.":>");
		$arr[] = $path;
		test($arr,$i,$lvl,$path);
	}
	
}


$path = Html::encode("<name1:>");
	
$arr[] = $path;



test($arr,2,3,$path);


var_dump($arr);


*/




?>



  
 <div class="row">
  
  	<div class="col-md-3" style="border:1px solid black">

	
	<?php
	
	
	
	
	if(isset($tree["roots"])){
	$keys = array_keys($tree["roots"]);
	for($i=min($keys);$i<=(max($keys));$i++){
		if(isset($tree["roots"][$i])){
			$json = json_decode($tree["roots"][$i],true);
			echo Html::a($json["name"], "/".$url."/".strtolower($json["alias"]))."<br>";
		}
	}
}else if(isset($tree["without_parents"])){
	$keys = array_keys($tree["without_parents"]);
	for($i=min($keys);$i<=(max($keys));$i++){
		if(isset($tree["without_parents"][$i])){
			foreach($tree["without_parents"][$i] as $key=>$val){
				$json = json_decode($key,true);
				echo Html::a($json["name"], "/".$url."/".strtolower($json["alias"]))."<br>";
				if(is_array($val)){
					foreach($val as $val2){
						echo Html::a($val2->name, "/".$url."/".strtolower($json["alias"])."/".strtolower($val2->alias))."<br>";
					}
					
				}
			}
		}
	}
	
}else if(isset($tree["with_parents"])){
	//pre($tree["with_parents"]);
	$keys = array_keys($tree["with_parents"]);
	for($i=min($keys);$i<=(max($keys));$i++){
		if(isset($tree["with_parents"][$i])){
			//pre($tree["with_parents"][$i]);
			foreach($tree["with_parents"][$i] as $key=>$val){
				$json = json_decode($key,true);
				echo Html::a($json["name"], "/".$url."/".strtolower($json["alias"]))."<br>";
				if(is_array($val)){
					//pre($val);
					if($keys2 = array_keys($val)){
						
						//pre($keys2);
					
						for($i2=min($keys2);$i2<=(max($keys2));$i2++){
							if(isset($val[$i2])){
								foreach($val[$i2] as $key2=>$val2){
									$json2 = json_decode($key2,true);
									echo Html::a($json2["name"], "/".$url."/".strtolower($json["alias"])."/".strtolower($json2["alias"]))."<br>";
									if(is_object($val2)){
										echo $val2->name;
									}else if(is_array($val2)){
										
										if($keys3 = array_keys($val2)){
											for($i3=min($keys3);$i3<=(max($keys3));$i3++){
												if(isset($val2[$i3])){
													if(is_object($val2[$i3])){
														//$json4 = $json2 = json_decode($val2[$i3],true);
														echo Html::a($val2[$i3]->name, "/".$url."/".strtolower($json["alias"])."/".strtolower($json2["alias"])."/".strtolower($val2[$i3]->alias))."<br>";
													}else if(is_array($val2[$i3])){
														foreach($val2[$i3] as $key3=>$val3){
															$json3 = json_decode($key3,true);
															echo Html::a($json3["name"], "/".$url."/".strtolower($json["alias"])."/".strtolower($json2["alias"])."/".strtolower($json3["alias"]))."<br>";
															if(is_object($val3)){
																//echo $val3->name."<br>";
															}else if(is_array($val3)){
																//pre($val3);
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					
					}
					/*
					
					*/
					
				}
			}
		}
		
	}
}	
	
	
	
	
	
	
	
	
	
	
	/*
	$url="basic/web/category";
	
	
	
	if(isset($current_url)){
		
		
		
		$bread_url = str_replace("/".$url."/","",$current_url);
		
		
		
		if($bread_url!="index"){
			$breads = explode("/",$bread_url);
			$breads = explode("?",$breads[0]);
			//var_dump($breads[0]);
		}else{
			$breads = null;
			$this->params['breadcrumbs'][] = false;
		}
	}
	
	if(isset($breads) && count($breads>=1)){
		
		
	
			function make_url(&$bread_url,$count,$i,$breads,&$bread_url_arr){
				if($i<$count-1){
					
					$i++;
					$bread_url.=$breads[$i]."/";
					$bread_url_arr[] = $bread_url;
					make_url($bread_url,$count,$i,$breads,$bread_url_arr);
				}
			}
			
			$bread_url = "/category/".$breads[0]."/";
		
			$bread_url_arr[] = $bread_url;
	
			make_url($bread_url,count($breads),0,$breads,$bread_url_arr);
			
			
			foreach($breads as $key=>$val){
				
				
				
				if($val != end($breads)){
	
					$this->params['breadcrumbs'][] = [
					
					'label' => ucfirst($val), // название ссылки 
					'url' => [Url::to($bread_url_arr[$key])] // сама ссылка
					
					];
					
					
					
					
			
				}else{
					$this->params['breadcrumbs'][] = [
					
					'label' => ucfirst($val), // название ссылки 
					
					
					];
					
					
					$this->params['breadcrumbs'][] = [
					
					"label" => "",
					
					];
					
					
				}
			
			}
			
			
					
	}	

	
	
	

	function pre($arr){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
	
	//pre($tree);
	
	
	
	
	$id = array_keys($tree);
	
	for($i=min($id);$i<=max($id);$i++){
		if(isset($tree[$i])){
		if(is_string($tree[$i])){
			echo $tree[$i]."<br>";
		}else if(is_object($tree[$i])){
			echo $tree[$i]->name."<br>";
		}else if(is_array($tree[$i])){
			
			foreach($tree[$i] as $key2=>$lvl2){
				echo $key2."<br>";
				
				if(is_string($lvl2)){
					
					echo $lvl2."<br>";
					
				}else if(is_object($lvl2)){
					
					echo $lvl2->name."<br>";
					
				}else if(is_array($lvl2)){
					
					$id2 = array_keys($lvl2);
					
					if(is_string(min($id2))){
						foreach($lvl2 as $key3=>$lvl3){
							echo $key3."<br>";
							if(is_array($lvl3)){
								
								foreach($lvl3 as $key4=>$lvl4){
									
									foreach($lvl4 as $key5=>$lvl5){
										echo $key5."<br>";
										
									}
								}
							}
						}
					}else if(is_numeric(min($id2))){
					
						for($i2=min($id2);$i2<=max($id2);$i2++){
							if(isset($lvl2[$i2])){
								
								if(is_string($lvl2[$i2])){
									echo $lvl2[$i2];
								}else if(is_object($lvl2[$i2])){
									echo $lvl2[$i2]->name."<br>";
								}else if(is_array($lvl2[$i2])){
									
									foreach($lvl2[$i2] as $key3=>$lvl3){
										echo $key3."<br>";
										foreach($lvl3 as $key4=>$lvl4){
											if(is_string($lvl4)){
												echo $lvl4;
											}else if(is_object($lvl4)){
												echo $lvl4->name."<br>";
											}else if(is_array($lvl4)){
												foreach($lvl4 as $key5=>$lvl5){
													echo $key5;
													
												} 
											}
										}
									}
								}
							}
						}
					
					}
					
			}		
				}
			}
			
		}	
	}
	
	
	/*
	
	
	for($i=min($id);$i<=max($id);$i++){
		
		if(is_string($tree[$i])){	
		echo $tree[$i];
		}else if(is_array($tree[$i])){
			foreach($tree[$i] as $key1=>$lvl1){
				echo $key1."<br>";
				if(is_string($lvl1)){
					echo $lvl1;
				}else if(is_object($lvl1)){
					echo $lvl1->name;
				}else if(is_array($lvl1)){
					
					if(isset($lvl1[0]) && is_object($lvl1[0])){
						foreach($lvl1 as $lvl2){
							echo $lvl2->name."<br>";
						}
					}else{
						foreach($lvl1 as $key=>$val){
							$id2[] = $key;
						}
						
						for($i=min($id2);$i<=max($id2);$i++){
							if(isset($lvl1[$i])){
								foreach($lvl1[$i] as $key2=>$lvl2){
									echo $key2."<br>";
									if(is_string($lvl2)){
										echo $lvl2."<br>";
									}else if(is_object($lvl2)){
										echo $lvl2->name;
									}else if(is_array($lvl2)){
										foreach($lvl2 as $key3=>$lvl3){
											//echo $key3;
											if(is_string($lvl3)){
												echo $lvl3;
											}else if(is_object($lvl3)){
												echo $lvl3->name;
											}else if(is_array($lvl3)){
												foreach($lvl3 as $key4=>$lvl4){
													echo $key4;
													if(is_string($lvl4)){
														echo $lvl4;
													}else if(is_object($lvl4)){
														echo $lvl4->name;
													}else if(is_array($lvl4)){
														foreach($lvl4 as $lvl5){
															echo $lvl5;
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
					
				}
			}
		}
	
	}
	
	*/
	

	
	
	//echo $_GET["name1"];
	
	/*
	
	for($i=min($id);$i<=max($id);$i++){
		
		if(isset($tree[$i])){
		
			if(is_array($tree[$i])){
			
				foreach($tree[$i] as $key=>$val){
					
					echo $key."<br>";
					
					
					
					foreach($val as $child){
						if(is_object($child)){
						$id2[] = $child->id;
						}else{
							
							foreach($child as $child2){
								if(is_object($child)){
								$id2[] = $child2->id;
								}
							}
							
						}
					}
					
					
					
					$is_array = false;
					
					
					
						
						
						foreach($val as $key2=>$lvl2){
							if(is_object($lvl2)){
							echo $lvl2->name."<br>";
							}else{
								$is_array = true;
							}
						}
						
						
						
						if($is_array){
							if(isset($id2)){
								for($i=$id;$i<=$id;$i++){
									if(isset($val[$i])){	
										if(is_array($val[$i])){
											foreach($val[$i] as $key2=>$lvl2){
												echo $key2."<br>";
												
												foreach($lvl2 as $lvl3){
													
													echo $lvl3->name;
												}
											}
										}
									}
								}
							}
						
						}
					
					
						
						foreach($val as $key2=>$lvl2){
							
							echo $key2."<br>";
							
							for($i=0;$i<=15;$i++){
								if(isset($lvl2[$i])){
									foreach($lvl2[$i] as $key3=>$lvl3){
										echo $key3."<br>";
									}
								}
							}
						}
					
						
						
					
					
				}
			
			}else{
				//1 ур
				echo $tree[$i];
			}
		
		}
		
	}
	
	

	
	*/

		
	
	
			
	/*
	
	foreach($tree as $key=>$val){
		$id[] = $key;
	}

	
	for($i=min($id);$i<=max($id);$i++){
		if(isset($tree[$i])){
			
				if(is_array($tree[$i])){
					
					$arr1 = get_tree($tree[$i],$url);
					
				}else if(is_object($tree[$i])){
					
					//echo Html::a($tree[$i]->name, "/".strtolower($tree[$i]->name))."<br>";
				
				}else{
					
					echo Html::a($tree[$i], "/".$url."/".strtolower($tree[$i]))."<br>";
					
				}
			
		}
	}
	
	*/
	
	
	
	function get_tree($arr,$url,$link=null){
		//for($i=0;$i<9;$i++){
			foreach($arr as $parent=>$child){
				if(is_numeric($parent)){
					echo $parent;
				}
				
				var_dump($parent);
				if(!is_object($child)){
					if(count($link)<2){
					$link[] = $parent;
					}else{
						array_pop($link);
						$link[] = $parent;
					}
				
					$new_link = implode("/",$link);
					echo Html::a($parent, "/".$url."/".strtolower($new_link))."<br>";
					get_tree($child,$url,$link);
				}else{
					//array_pop($link);
					if(count($link)==$child->depth){
						$link[] = $child->name;
					}else{
						array_pop($link);
						$link[] = $child->name;
					}
					
					$new_link = implode("/",$link);
					//echo $child->depth;
					
					echo Html::a($child->name, "/".$url."/".strtolower($new_link))."<br>";
				}
			}
		
		//}
	}
	
	
	
	?>


	</div>


   <div class="col-md-9" style="border:1px solid black">

		
		
		<?php
		if(isset($data["products"]) || isset($data["children"])){
			?>
			<h2 class='text-center'>
			
			<?php
				echo $data["category"];
			?>
			
			</h2>
			<?php
		}else if(isset($category)){
			
		echo "<h2 class='text-center'>".$category."</h2>";
	
		}
		?>
		
		<div class="jumbotron">
			<div class="row text-center" >   
				<?php

				if(isset($data["products"])){
					
					foreach($data["products"] as $val){
						?>
						<div class='col-md-3 col-md-offset-1' style='border:1px solid black'>
						<div><?=$val->name;?></div><br>
						<div> <img src="<?=Url::to(['/uploads']);?>/<?=$val->img;?>"></div><br>
						
						
						</div>
						<?php
					}
					
					
				}else if(isset($data["children"])){
					
					foreach($data["children"] as $val){
						if(is_object($val)){
							echo "<div class='col-md-3 col-md-offset-1' style='border:1px solid black'>".$val->name."</div>";
						}
					}
					
				}
				
				?>
		
			</div>		
			
		</div>
	
		<?php
	
		if(isset($data["pagination"])){
   
			echo "<div class='text-center'>".LinkPager::widget(['pagination' => $data["pagination"]])."</div>";
  
		}
	
		?>

	</div>
	
</div>	



	
	


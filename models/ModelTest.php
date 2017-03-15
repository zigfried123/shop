<?php

namespace app\models;

use Yii;

use yii\base\Model;

use yii\helpers\VarDumper;

class TestModel extends Model
{
	public $name;
	
	public function rules(){
		return ["name","required"];
	}
}


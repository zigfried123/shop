<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;



class LogoutForm extends Model
{
		

	public $logout;
	
	
	public function rules()
    {
        return [
			
			['logout', 'required'],
			
			
        ];
    }
	

	
	
	


}

?>
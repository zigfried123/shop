<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use yii\web\Session;


class ShopForm extends ActiveRecord
{
	

	
	
   
   
    public function rules()
    {
        return [
			
			[['login', 'pass'], 'required'],
			
			[['login', 'pass'], 'unique'],
			
			
        ];
    }
	
	
	
	
	


}





/*

class ShopDel extends Model{
	public $delete;
	
	public function rules()
    {
        return [
			
			['delete', 'required'],
					
        ];
    }
}
*/





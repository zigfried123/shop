<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\data\Pagination;

class Country extends ActiveRecord
{
	public $data = array();
	
	public static function find_countries(){
		$query = self::find();
		
		$pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);
		
		$countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
			
		return $data = array("pagination"=>$pagination,"countries"=>$countries);
			
		
	}
	
	
	
	
		
	
}
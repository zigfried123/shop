<?php

namespace app\models\shop;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;
use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\helpers\VarDumper;



 

 
 
class FormProducts extends ActiveRecord
{
	
	

   
	
	
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id','name','img'], 'required'],
			[['cat_id','name'], 'checkProduct']
			
        ];
    }
	
	
	public function attributeLabels()
	{
		 return ["name"=>"Выбрать категорию"];
	}

	
	public function checkProduct($attribute,$params){
		
		
		
		
		$find = AlterTable::find()->where(["id"=>$this->cat_id])->one();
		
		$this->category = $find->alias;
		
		$this->category_rus = $find->name;
		
		
		$find = $this->find()->where(["cat_id"=>$this->cat_id,"name"=>$this->name])->one();
		
		
	
		if(isset($find)){
			$this->addError('name',"Такой продукт в этой категории уже есть");
		}
				
	}
	
	

	
	
	public static function translit($str){
		
		$convert = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		
		$translit = strtr($str, $convert);
		
		return $translit;
	}
	
	
	
	public function getTree(){
		$roots = Category::find()->roots()->all();
		foreach($roots as $root){
			$children = $root->children()->all();
			
			$tree[$root->id] = $root->depth.". ".$root->name;
			
			foreach($children as $child){
				if($child->depth==1){
					$space = "---";
				}else if($child->depth==2){
					$space = "------";
				}
				
					$tree[$child->id] = $space.$child->depth.". ".$child->name;
				
			}
			
		}
		
		return $tree;
	
	}
	
	

    /**
     * @inheritdoc
     */
    
}


class AlterTable extends ActiveRecord
{
   
 
    public static function tableName()
    {
        return '{{tbl_category}}';
    }
}






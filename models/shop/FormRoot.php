<?php

namespace app\models\shop;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\Pagination;
use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "tbl_category".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $alias
 * @property string $title
 * @property string $meta_k
 * @property string $meta_d
 * @property string $img
 * @property integer $order
 * @property integer $show
 * @property string $txt
 * @property string $cssclass
 * @property string $htmlview
 * @property integer $tree
 */
class FormRoot extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'checkRoot']
        ];
    }


    public function attributeLabels()
    {
        return ["name" => "Корневая категория"];
    }


    public function checkRoot($attribute, $params)
    {

        //$find = self::find()->where(["alias"=>$this->name])->one();


        $roots = Category::find()->roots()->all();

        foreach ($roots as $root_find) {
            if ($root_find->name == $this->name) {
                $find = true;
                break;
            }
        }

        if (isset($find) && $find) {
            $this->addError('name', "Такая корневая категория уже есть");
        }


    }


    public function makeRoot($root)
    {
        $category = new Category(['name' => $root, 'alias' => self::translit($root)]);
        $category->makeRoot();
    }


    public static function translit($str)
    {

        $convert = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );

        $translit = strtr($str, $convert);

        return $translit;
    }


    /**
     * @inheritdoc
     */

}


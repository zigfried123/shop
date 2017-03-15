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


class FormCategory extends \yii\db\ActiveRecord
{

    public $cat;

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


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
            [['id', 'name'], 'required'],
            [['id', 'name'], 'checkCat']
        ];
    }


    public function attributeLabels()
    {
        return ["name" => "Выбрать категорию"];
    }


    public function checkCat($attribute, $params)
    {

        $cat = $this->findOne(['id' => $this->id]);
        $children = $cat->children()->all();

        if (isset($children)) {

            foreach ($children as $child) {
                if ($child->name == $this->name) {
                    $this->addError('name', "Такая подкатегория уже есть");
                }
            }

        }

    }


    public function makeCategory($id, $cat)
    {

        $find = $this->find()->where(["id" => $id])->one();

        $category = new Category(['name' => $cat, 'alias' => self::translit($cat)]);
        $category->appendTo($find);
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


    public function getTree()
    {
        $roots = Category::find()->roots()->all();
        foreach ($roots as $root) {
            $children = $root->children()->all();

            $tree[$root->id] = $root->depth . ". " . $root->name;

            foreach ($children as $child) {
                if ($child->depth == 1) {
                    $space = "---";
                }
                if ($child->depth < 2) {
                    $tree[$child->id] = $space . $child->depth . ". " . $child->name;
                }
            }

        }

        return $tree;

    }


    /**
     * @inheritdoc
     */

}








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

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}


class Category extends \yii\db\ActiveRecord
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

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }


    public static function check_exceptions($cat = null, $lvl = 1, $url_get = null)
    {


        if (count($url_get) > 1) {
            array_pop($url_get);
        }


        $findAll = Category::findAll(["alias" => $cat]);

        //если не найден или уровни не совпадают - исключение

        $find = null;


        foreach ($findAll as $finds) {


            $parents = $finds->parents()->all();

            if (!empty($parents)) {


                foreach ($parents as $parent) {


                    if ($lvl == 1) {

                        if (in_array(lcfirst($parent->alias), $url_get)) {
                            $find = $finds;


                        }

                    } else if ($lvl > 1) {
                        $parents_find[] = lcfirst($parent->alias);


                    }

                }


            } else {

                $find = $finds;
            }


            if (!empty($parents_find)) {

                if ($url_get == $parents_find) {
                    $find = $finds;
                    break;
                }

            }


        }

        if (!isset($find) || $find->depth != $lvl) {
            throw new \yii\web\HttpException(404, "error");
        }


        return $find;


    }


    public static function findCategory($cat)
    {

        $find = self::find()->where(["alias" => $cat])->one();

        return $find;

    }


    public static function getSubCategories($cat = null, $lvl = 1, $url_get = null)
    {


        if (isset($cat) && $cat != "index" && $cat != "admin") {


            $find = self::check_exceptions($cat, $lvl, $url_get);


            $children = $find->children(1)->all();

            foreach ($children as $val) {

                $children_name[] = $val->name;

            }

            $pagination = new Pagination([
                'defaultPageSize' => 3,
                'totalCount' => count($children),
            ]);

            if (isset($children_name)) {
                foreach ($children_name as $child_name) {
                    $children[] = self::find()->where(["name" => $child_name])->offset($pagination->offset)->limit($pagination->limit)->all();
                }
            }


            if (!empty($children)) {

                $category = ucfirst(self::translit($cat));

                $children = ["children" => $children, "pagination" => $pagination, "category" => $find->name];

                return $children;

            }


        }


    }


    public static function getProducts($cat = null, $lvl, $url_get)
    {

        if (isset($cat) && $cat != "index" && $cat != "admin") {

            $find = self::check_exceptions($cat, $lvl, $url_get);


            $products = new Products;


            $query = $products->find()->where(["cat_id" => $find->id, "category" => $cat]);

            $pagination = new Pagination([
                'defaultPageSize' => 3,
                'totalCount' => $query->count(),
            ]);


            $products = $query->offset($pagination->offset)->limit($pagination->limit)->all();

            if (count($products) > 0) {

                $products = ["products" => $products, "pagination" => $pagination, "category" => $products[0]->category_rus];


                return $products;

            }


        }


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
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
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
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );

        $translit = strtr($str, $convert);

        return $translit;
    }


    public static function getRoot($cat = null, $lvl = 1, $url_get = null)
    {


        $roots = Category::find()->roots()->all();


        if (isset($cat) && $cat != "index") {

            $roots = Category::find()->roots()->all();


            $find = self::check_exceptions($cat, $lvl, $url_get);


            //если уровень категории совпадает с уровнем урл
            if (isset($find) && $find->depth == $lvl) {


                //все родители всех уровней
                $parents = $find->parents()->all();
                //все дети первого уровня
                $children = $find->children(1)->all();


                $tree["tree2"] = [[[111, 777]], [222], [[333]]];
                $tree["tree2"][1][] = 123;


                foreach ($parents as $parent) {
                    $tree["breads"][] = ["name" => $parent->name, "alias" => lcfirst($parent->alias)];
                }

                $tree["breads"][] = ["name" => $find->name, "alias" => lcfirst($find->alias)];


                if (isset($url_get)) {

                    if (!empty($parents)) {

                        foreach ($parents as $parent) {

                            if (!in_array(lcfirst($parent->alias), $url_get)) {
                                //throw new \yii\web\HttpException(404, "error");
                            }
                        }
                    }
                }

                //если есть родители
                if (!empty($parents)) {
                    //если есть родители и дети
                    if (!empty($children)) {
                        foreach ($parents as $parent) {

                            $tree["with_parents"][$parent->id][json_encode(["name" => $parent->name, "alias" => $parent->alias])][$find->id][json_encode(["name" => $find->name, "alias" => $find->alias])] = $children;

                        }

                    } else {

                        if (count($parents) == 1) {

                            $tree["with_parents"][$parents[0]->id][json_encode(["name" => $parents[0]->name, "alias" => $parents[0]->alias])][$find->id][json_encode(["name" => $find->name, "alias" => $find->alias])] = [];

                        } else if (count($parents) == 2) {

                            $tree["with_parents"][$parents[0]->id][json_encode(["name" => $parents[0]->name, "alias" => $parents[0]->alias])][$parents[1]->id][json_encode(["name" => $parents[1]->name, "alias" => $parents[1]->alias])][$find->id][json_encode(["name" => $find->name, "alias" => $find->alias])] = [];


                        }

                    }

                    //если корневой
                } else {
                    //если корневой и есть дети
                    if (!empty($children)) {
                        $tree["without_parents"][$find->id][json_encode(["name" => $find->name, "alias" => $find->alias])] = $children;
                    } else {
                        $tree["without_parents"][$find->id][json_encode(["name" => $find->name, "alias" => $find->alias])] = [];
                    }
                }

                if (!empty($tree["without_parents"])) {
                    foreach ($roots as $root) {
                        if (empty($tree["without_parents"][$root->id])) {
                            $tree["without_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])] = [];
                        }
                    }
                }


                //в массив заполняются другие корни и дети корней
                if (!empty($tree["with_parents"])) {


                    foreach ($roots as $root) {

                        if (empty($tree["with_parents"][$root->id])) {
                            $tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])] = [];
                        } else {

                            $parents1 = $find->parents(1)->one();

                            $parents2 = $find->parents(2)->one();

                            $parents_children1 = $parents2->children(1)->all();

                            $parents_children2 = $parents1->children(1)->all();

                            if ($lvl == 1) {


                                foreach ($parents_children1 as $parents_child) {
                                    if (empty($tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id])) {
                                        $tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id][json_encode(["name" => $parents_child->name, "alias" => $parents_child->alias])] = [];
                                    }
                                }



                            } else if ($lvl == 2) {


                                foreach ($parents_children1 as $parents_child) {
                                    if (empty($tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id])) {

                                        $tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id][json_encode(["name" => $parents_child->name, "alias" => $parents_child->alias])] = [];
                                    } else {

                                        foreach ($parents_children2 as $parents_child2) {
                                            if (empty($tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id][json_encode(["name" => $parents_child->name, "alias" => $parents_child->alias])][$parents_child2->id])) {
                                                $tree["with_parents"][$root->id][json_encode(["name" => $root->name, "alias" => $root->alias])][$parents_child->id][json_encode(["name" => $parents_child->name, "alias" => $parents_child->alias])][$parents_child2->id][json_encode(["name" => $parents_child2->name, "alias" => $parents_child2->alias])] = [];
                                            }
                                        }

                                    }
                                }


                            }

                        }


                    }


                }


            }


            //если главная страница выводятся корни
        } else {

            foreach ($roots as $root) {
                $tree["roots"][$root->id] = json_encode(["name" => $root->name, "alias" => $root->alias]);
            }

        }


        if (isset($tree)) {
            return $tree;
        }


    }

    public static function setRoot()
    {





    }


    public static function tablename()
    {
        return '{{tbl_category}}';
    }


}


class Products extends ActiveRecord
{


    public static function tableName()
    {
        return '{{tbl_products}}';
    }
}


?>
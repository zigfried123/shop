<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\shop\Category;
use app\models\shop\FormRoot;
use app\models\shop\FormCategory;
use app\models\shop\FormProducts;
use yii\helpers\BaseUrl;
use yii\web\ErrorAction;
use yii\web\HttpException;
use yii\web\Session;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class CategoryController extends Controller
{


    public $layout = 'menu';


    public function actionView($id)
    {
        $arr_ancestors = array();

        $category = Category::model()->find(array(
            'condition' => 'id=:id',
            'params' => array(':id' => $id),
        ));

        $ancestors = $category->ancestors()->findAll();

        foreach ($ancestors as $ancestor) {
            $arr_ancestors[] = $ancestor->name;
        }

        $this->render('view', array(
            'arr_ancestors' => $arr_ancestors,
            'model' => $this->loadModel($id),
        ));
    }


    public function actionCreate()
    {
        $model = new Category;
        $root = Category::getRoot($model);
        $descendants = $root->descendants()->findAll();

        if (isset($_POST['Category'])) {
            $parent_id = (int)$_POST['Category']['parent_id'];
            $root = Category::model()->findByPk($parent_id);
            $model->attributes = $_POST['Category'];
            if ($model->appendTo($root)) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'root' => $root,
            'categories' => $descendants,
            'parent_id' => null,
            'id' => null,
        ));
    }


    public function actionUpdate($id)
    {
        $root = Category::getRoot(new Category);
        $descendants = $root->descendants()->findAll();

        $model = $this->loadModel($id);

        $parent = $model->parent()->find();
        $parent_id = $parent ? $parent->id : null;

        if (isset($_POST['Category'])) {
            $parent_id = (int)$_POST['Category']['parent_id'];

            $node = Category::model()->findByPk($parent_id);

            $model->attributes = $_POST['Category'];

            if ($model->lft == 1 || $model->id == $node->id) {
                if ($model->saveNode()) {
                    Yii::app()->user->setFlash('category_error', "Структура дерева не изменена.");
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                if ($model->saveNode()) {
                    if ($node->isDescendantOf($model)) {
                        Yii::app()->user->setFlash('category_error', "Структура дерева не изменена.");
                    } else {
                        $model->moveAsLast($node);
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'root' => $root,
            'categories' => $descendants,
            'parent_id' => $parent_id,
            'id' => $id,
        ));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->deleteNode();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    public function actionCategories()
    {

        $this->layout = "admin";

        $model = new FormRoot();


        if (!isset($_POST["FormRoot"])) {

            return $this->render('admin/categories', ["model" => $model]);

        } else {

            $model->attributes = $_POST["FormRoot"];

            if ($model->validate()) {

                $flash = Yii::$app->getSession()->setFlash('success_root', 'Корневая категория успешно добавлена на страницу');

                $model->makeRoot($model->name);

                $this->refresh();

            } else {

                return $this->render('admin/categories', ["model" => $model]);

            }

        }


    }

    public function actionSubcategories()
    {

        $this->layout = "admin";

        $model = new FormCategory;


        if (isset($_POST["FormCategory"])) {

            $model->attributes = $_POST["FormCategory"];


            if ($model->validate()) {

                $flash = Yii::$app->getSession()->setFlash('success_category', 'Подкатегория успешно добавлена на страницу');

                $model->makeCategory($model->id, $model->name);

                $this->refresh();

            } else {
                return $this->render('admin/subcategories', ["model" => $model]);
            }


        } else {

            return $this->render('admin/subcategories', ["model" => $model]);

        }

    }

    public function actionProducts()
    {
        $this->layout = "admin";

        $model = new FormProducts;


        if (isset($_POST["FormProducts"])) {

            $model->attributes = $_POST["FormProducts"];

            $model->img = UploadedFile::getInstance($model, 'img');


            if ($model->validate()) {

                $flash = Yii::$app->getSession()->setFlash('success_product', 'Продукт успешно добавлен на страницу');


                if ($model->save()) {

                    $model->img->saveAs('uploads/products/' . $model->img->baseName . '.' . $model->img->extension);


                    $this->refresh();

                }


            } else {
                return $this->render('admin/products', ["model" => $model]);
            }
        } else {
            return $this->render('admin/products', ["model" => $model]);
        }
    }


    public function actionAdmin()
    {
        $this->layout = "admin";


        return $this->render('admin');

    }


    public function actionIndex()
    {
        $model = new Category;

        $tree = Category::getRoot();


        $url = BaseUrl::current();


        $url = urldecode($url);


        if (isset($_GET["level3"])) {

            $url_end = [$_GET["level1"], $_GET["level2"], $_GET["level3"]];

            $tree = Category::getRoot(end($url_end), 2, $url_end);

            $children = Category::getSubCategories(end($url_end), 2, $url_end);

            $products = Category::getProducts(end($url_end), 2, $url_end);

        } else if (isset($_GET["level2"])) {

            $url_end = [$_GET["level1"], $_GET["level2"]];

            $tree = Category::getRoot(end($url_end), 1, $url_end);

            $children = Category::getSubCategories(end($url_end), 1, $url_end);

            $products = Category::getProducts(end($url_end), 1, $url_end);

        } else if (isset($_GET["level1"])) {

            $url_end = [$_GET["level1"]];

            $tree = Category::getRoot(end($url_end), 0, $url_end);

            $children = Category::getSubCategories(end($url_end), 0, $url_end);

            $products = Category::getProducts(end($url_end), 0, $url_end);

        } else {
            $url_end[] = "index";
            $tree = Category::getRoot("index");


        }


        if (ctype_upper(end($url_end))) {
            throw new \yii\web\HttpException(404, end($url_end));
        }


        //сначала поиск по вложенным категориям, затем по продуктам

        //если главнаЯ

        if (end($url_end) == "index") {

            return $this->render('index', ['tree' => $tree, 'category' => "Главная", 'current_url' => $url]);

        } else {

            //если найдены подкатегории

            if (isset($children)) {

                return $this->render('index', ['tree' => $tree, 'data' => $children, 'current_url' => $url]);

            } else {


                //если найдены продукты

                if (isset($products)) {
                    return $this->render('index', ['tree' => $tree, 'data' => $products, 'current_url' => $url]);

                    //если не главнаЯ, не найдены подкатегории и продукты
                } else {

                    return $this->render('index', ['tree' => $tree, 'current_url' => $url, "category" => Category::findCategory(end($url_end))->name]);

                }

            }


        }


    }


    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
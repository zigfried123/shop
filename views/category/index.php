<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\widgets\LinkPager;

?>




<?php

$arr1 = [1, 2, 3];

$arr2 = [4, 5, 3];


$arr["name"][] = [$arr1];

$arr["name"][] = [array_intersect($arr2, $arr1), "hgh"];


$url = "basic/web/category";

if (isset($tree["breads"])) {
//pre($tree["breads"]);
}


if (!empty(isset($tree["breads"][2]))) {

    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки
        'url' => ["/category" . "/" . $tree["breads"][0]["alias"] . "/"] // сама ссылка

    ];

    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][1]["name"]), // название ссылки
        'url' => ["/category" . "/" . $tree["breads"][0]["alias"] . "/" . $tree["breads"][1]["alias"] . "/"] // сама ссылка

    ];


    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][2]["name"]), // название ссылки


    ];


    $this->params['breadcrumbs'][] = false;


} else if (!empty($tree["breads"][1])) {

    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки
        'url' => ["/category" . "/" . $tree["breads"][0]["alias"] . "/"] // сама ссылка

    ];

    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][1]["name"]), // название ссылки


    ];

    $this->params['breadcrumbs'][] = false;

} else if (!empty($tree["breads"][0])) {

    $this->params['breadcrumbs'][] = [

        'label' => ucfirst($tree["breads"][0]["name"]), // название ссылки


    ];


    $this->params['breadcrumbs'][] = false;


} else {

    $this->params['breadcrumbs'][] = false;
}


if (isset($tree["with_parents2"])) {
    pre($tree["with_parents2"]);
    foreach ($tree["with_parents2"] as $key => $val) {

        if (is_object($val)) {
            echo $val->name;
        }
        if (is_array($val)) {
            foreach ($val as $key2 => $val2) {
                if (is_object($val2)) {
                    echo $val2->name . "<br>";
                } else if (is_array($val2->name)) {
                    pre($val2->name);
                }
            }
        }
    }
}


function pre($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}


?>


<div class="row">

    <div class="col-md-3" style="border:1px solid black">


        <?php


        if (isset($tree["roots"])) {
            $keys = array_keys($tree["roots"]);
            for ($i = min($keys); $i <= (max($keys)); $i++) {
                if (isset($tree["roots"][$i])) {
                    $json = json_decode($tree["roots"][$i], true);
                    echo Html::a($json["name"], "/" . $url . "/" . strtolower($json["alias"])) . "<br>";
                }
            }
        } else if (isset($tree["without_parents"])) {
            $keys = array_keys($tree["without_parents"]);
            for ($i = min($keys); $i <= (max($keys)); $i++) {
                if (isset($tree["without_parents"][$i])) {
                    foreach ($tree["without_parents"][$i] as $key => $val) {
                        $json = json_decode($key, true);
                        echo Html::a($json["name"], "/" . $url . "/" . strtolower($json["alias"])) . "<br>";
                        if (is_array($val)) {
                            foreach ($val as $val2) {
                                echo Html::a($val2->name, "/" . $url . "/" . strtolower($json["alias"]) . "/" . strtolower($val2->alias)) . "<br>";
                            }

                        }
                    }
                }
            }

        } else if (isset($tree["with_parents"])) {
            //pre($tree["with_parents"]);
            $keys = array_keys($tree["with_parents"]);
            for ($i = min($keys); $i <= (max($keys)); $i++) {
                if (isset($tree["with_parents"][$i])) {
                    //pre($tree["with_parents"][$i]);
                    foreach ($tree["with_parents"][$i] as $key => $val) {
                        $json = json_decode($key, true);
                        echo Html::a($json["name"], "/" . $url . "/" . strtolower($json["alias"])) . "<br>";
                        if (is_array($val)) {
                            //pre($val);
                            if ($keys2 = array_keys($val)) {

                                //pre($keys2);

                                for ($i2 = min($keys2); $i2 <= (max($keys2)); $i2++) {
                                    if (isset($val[$i2])) {
                                        foreach ($val[$i2] as $key2 => $val2) {
                                            $json2 = json_decode($key2, true);
                                            echo Html::a($json2["name"], "/" . $url . "/" . strtolower($json["alias"]) . "/" . strtolower($json2["alias"])) . "<br>";
                                            if (is_object($val2)) {
                                                echo $val2->name;
                                            } else if (is_array($val2)) {

                                                if ($keys3 = array_keys($val2)) {
                                                    for ($i3 = min($keys3); $i3 <= (max($keys3)); $i3++) {
                                                        if (isset($val2[$i3])) {
                                                            if (is_object($val2[$i3])) {
                                                                //$json4 = $json2 = json_decode($val2[$i3],true);
                                                                echo Html::a($val2[$i3]->name, "/" . $url . "/" . strtolower($json["alias"]) . "/" . strtolower($json2["alias"]) . "/" . strtolower($val2[$i3]->alias)) . "<br>";
                                                            } else if (is_array($val2[$i3])) {
                                                                foreach ($val2[$i3] as $key3 => $val3) {
                                                                    $json3 = json_decode($key3, true);
                                                                    echo Html::a($json3["name"], "/" . $url . "/" . strtolower($json["alias"]) . "/" . strtolower($json2["alias"]) . "/" . strtolower($json3["alias"])) . "<br>";
                                                                    if (is_object($val3)) {
                                                                        //echo $val3->name."<br>";
                                                                    } else if (is_array($val3)) {
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

        function get_tree($arr, $url, $link = null)
        {
            //for($i=0;$i<9;$i++){
            foreach ($arr as $parent => $child) {
                if (is_numeric($parent)) {
                    echo $parent;
                }

                var_dump($parent);
                if (!is_object($child)) {
                    if (count($link) < 2) {
                        $link[] = $parent;
                    } else {
                        array_pop($link);
                        $link[] = $parent;
                    }

                    $new_link = implode("/", $link);
                    echo Html::a($parent, "/" . $url . "/" . strtolower($new_link)) . "<br>";
                    get_tree($child, $url, $link);
                } else {
                    //array_pop($link);
                    if (count($link) == $child->depth) {
                        $link[] = $child->name;
                    } else {
                        array_pop($link);
                        $link[] = $child->name;
                    }

                    $new_link = implode("/", $link);
                    //echo $child->depth;

                    echo Html::a($child->name, "/" . $url . "/" . strtolower($new_link)) . "<br>";
                }
            }


        }


        ?>


    </div>


    <div class="col-md-9" style="border:1px solid black">


        <?php
        if (isset($data["products"]) || isset($data["children"])) {
            ?>
            <h2 class='text-center'>

                <?php
                echo $data["category"];
                ?>

            </h2>
            <?php
        } else if (isset($category)) {

            echo "<h2 class='text-center'>" . $category . "</h2>";

        }
        ?>

        <div class="jumbotron">
            <div class="row text-center">
                <?php

                if (isset($data["products"])) {

                    foreach ($data["products"] as $val) {
                        ?>
                        <div class='col-md-3 col-md-offset-1' style='border:1px solid black'>
                            <div><?= $val->name; ?></div>
                            <br>
                            <div><img src="<?= Url::to(['/uploads']); ?>/<?= $val->img; ?>"></div>
                            <br>


                        </div>
                        <?php
                    }


                } else if (isset($data["children"])) {

                    foreach ($data["children"] as $val) {
                        if (is_object($val)) {
                            echo "<div class='col-md-3 col-md-offset-1' style='border:1px solid black'>" . $val->name . "</div>";
                        }
                    }

                }

                ?>

            </div>

        </div>

        <?php

        if (isset($data["pagination"])) {

            echo "<div class='text-center'>" . LinkPager::widget(['pagination' => $data["pagination"]]) . "</div>";

        }

        ?>

    </div>

</div>	



	
	


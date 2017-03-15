<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\Country;

class CountryController extends Controller
{
    public function actionIndex()
    {
	
	$countries = Country::find_countries()["countries"];
	
	$pagination = Country::find_countries()["pagination"];

        return $this->render('Index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }
}
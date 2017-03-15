<?php

namespace app\models\test;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property string $user
 * @property integer $score
 */
class RatingModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'score'], 'required'],
            [['user'], 'string'],
            [['score'], 'integer'],
        ];
    }

   
  
	
	
	
	
}

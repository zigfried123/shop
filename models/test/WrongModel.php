<?php

namespace app\models\test;

use Yii;

/**
 * This is the model class for table "wrong".
 *
 * @property string $question
 * @property string $answer
 */
class WrongModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wrong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer'], 'required'],
            [['question', 'answer'], 'string'],
        ];
    }

    
}

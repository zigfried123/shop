<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testgii".
 *
 * @property integer $test
 */
class Testgii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testgii';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['test'], 'required'],
            [['test'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'test' => 'Test',
        ];
    }
}

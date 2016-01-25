<?php

namespace common\models\users;

use Yii;

/**
 * This is the model class for table "user_account".
 *
 * @property string $id
 * @property string $id_user
 * @property string $pay_in
 * @property string $pay_out
 * @property string $invoice
 * @property string $date
 * @property string $description
 * @property string $service
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user'], 'integer'],
            [['pay_in', 'pay_out'], 'number'],
            [['date'], 'safe'],
            [['invoice'], 'string', 'max' => 32],
            [['description', 'service'], 'string', 'max' => 80],
            [['invoice'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'pay_in' => 'Приход',
            'pay_out' => 'Расход',
            'invoice' => 'Счет №',
            'date' => 'Дата',
            'description' => 'Информация',
            'service' => 'Услуга',
        ];
    }
}

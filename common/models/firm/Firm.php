<?php

namespace common\models\firm;

use Yii;

/**
 * This is the model class for table "firm".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_user
 * @property integer $status
 * @property integer $show_requisites
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property string $site
 * @property string $logo
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $mk
 * @property string $md
 *
 * @property FirmCat $idCat
 */
class Firm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'firm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['tel', 'email', 'site', 'logo', 'mk', 'md'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => FirmCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Категория',
            'id_user' => 'Пользователь',
            'status' => 'Статус',
            'show_requisites' => 'Показывать реквизиты',
            'name' => 'Название компании',
            'tel' => 'Телефон',
            'email' => 'Email',
            'site' => 'Сайт',
            'logo' => 'Логотип',
            'description' => 'Описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'mk' => 'Ключевые слова',
            'md' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(FirmCat::className(), ['id' => 'id_cat'])->inverseOf('firms');
    }
}

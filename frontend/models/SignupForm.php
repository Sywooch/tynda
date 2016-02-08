<?php
namespace frontend\models;

use common\models\User;
use common\models\users\Company;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $company;
    public $name;
    public $surname;
    public $patronym;
    public $tel;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required', 'message' => 'Заполните пожалуйста поле.'],
            ['username', 'filter', 'filter' => 'trim'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такое имя уже используется.'],
            [['surname', 'patronym'], 'required'],
            [['username', 'name', 'surname', 'patronym'], 'string', 'min' => 2, 'max' => 50],
            [['username', 'name', 'surname', 'patronym'], 'filter', 'filter' => 'strip_tags'],

            ['company','integer'],

            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот email адрес уже используется.'],

            ['password', 'required', 'message' => 'Введите пароль (мин. 6 символов)'],
            [['password'], 'string', 'min' => 6, 'message' => 'Пароль должен содержать не менее 6 символов.'],
            ['password', 'filter', 'filter' => 'strip_tags'],

            ['tel', 'required'],
            [['tel'], 'string', 'max' => 15],
            [['tel'], 'match', 'pattern'=>'/^(\+7)\d{10,10}$/', 'message' => 'Номер мобильного телефона должен иметь вид "+79047771199".'],
            ['tel', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот телефонный номер уже используется.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password'=>'Пароль',
            'id' => 'ID',
            'username' => \common\models\users\User::isCompany() ? 'Компания' : 'Логин',
            'email' => 'Email',
            'tel'=>'Тел',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronym' => 'Отчество',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->company = $this->company;
            if($this->company == 1){
                $user->username = $this->username;
                $user->name = $this->name;
            }else{
                $user->username = $this->username;
                $user->name = $this->username;
            }
            $user->surname = $this->surname;
            $user->patronym = $this->patronym;
            $user->tel = $this->tel;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                if($this->company == 1){
                    $company = new Company();
                    $company->id_user = $user->id;
                    $company->name = $this->username;
                    $company->legal_name = $this->username;
                    $company->save();
                }
                return $user;
            }
        }

        return null;
    }
}

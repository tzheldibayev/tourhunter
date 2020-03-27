<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;
use app\factories\UserFactory;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 100],
        ];
    }

    /**
     * Logs in a user using the provided username.
     *
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\Exception
     */
    public function login()
    {
        if ($this->validate()) {

            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }

    /**
     * Find or create new user if its not exists.
     *
     * @return User
     * @throws \yii\base\Exception
     */
    public function getUser()
    {
        $user = User::findByUsername($this->username);

        if (null === $user) {
            $user = UserFactory::create($this->username);
        }

        return $user;
    }
}

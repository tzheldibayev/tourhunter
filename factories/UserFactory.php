<?php

namespace app\factories;

use app\models\User;

class UserFactory
{
    /**
     * @param $username
     *
     * @return User
     * @throws \yii\base\Exception
     */
    public static function create($username): User
    {
        $user = new User();
        $user->username = $username;
        $user->generateAccessToken();
        $user->generateAuthKey();
        $user->save();

        return $user;
    }
}

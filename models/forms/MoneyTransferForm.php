<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;
use app\factories\UserFactory;

/**
 * Class MoneyTransferForm.
 *
 * Validation rules for money transfering
 * from one to another user.
 *
 * @package app\models\forms
 */
class MoneyTransferForm extends Model
{
    public $username;
    public $amount;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'amount', 'verifyCode'], 'required'],
            [['amount'], 'double'],
            ['verifyCode', 'captcha', 'captchaAction'=>'site/captcha'],
        ];
    }
}

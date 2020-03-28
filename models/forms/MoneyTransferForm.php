<?php

namespace app\models\forms;

use yii\base\Model;

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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'amount'], 'required'],
            [['amount'], 'double'],
        ];
    }
}

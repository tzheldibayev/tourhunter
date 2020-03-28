<?php

namespace app\services;

use app\models\User;
use foo\bar;
use yii\helpers\VarDumper;

class BalanceService
{
    protected $db;
    protected $message;

    public function __construct()
    {
        $this->db = \Yii::$app->getDb();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param User $from
     * @param User $to
     * @param float $amount
     *
     * @return bool
     */
    public function transfer(User $from, User $to, float $amount)
    {
        $transaction = $this->db->beginTransaction();
        try {
            $this->handle($from, $to, $amount, $transaction);
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
            $transaction->rollBack();
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @param float $amount
     */
    protected function increaseBalance(User $user, float $amount)
    {
        $user->balance += $amount;
        $user->save();
    }

    /**
     * @param User $user
     * @param float $amount
     */
    protected function decreaseBalance(User $user, float $amount)
    {
        $user->balance -= $amount;
        if ($user->balance < User::MIN_BALANCE) {
            throw new \LogicException('User\'s balance can not be less than ' . User::MIN_BALANCE);
        }
        $user->save();
    }

    /**
     * @param User $sender
     * @param User $reciever
     */
    protected function checkRestrictions(User $sender, User $reciever): void
    {
        if ($sender->id === $reciever->id) {
            throw new \LogicException('You can not send money to yourself.');
        }
    }

    /**
     * @param $amount
     */
    protected function checkAmountForNegative($amount)
    {
        if ($amount < 0) {
            throw new \LogicException('You can not send negative value.');
        }
    }

    /**
     * @param User $from
     * @param User $to
     * @param float $amount
     * @param \yii\db\Transaction $transaction
     *
     * @throws \yii\db\Exception
     */
    protected function handle(User $from, User $to, float $amount, \yii\db\Transaction $transaction): void
    {
        $this->checkRestrictions($from, $to);
        $this->checkAmountForNegative($amount);
        $this->decreaseBalance($from, $amount);
        $this->increaseBalance($to, $amount);
        $transaction->commit();
    }
}

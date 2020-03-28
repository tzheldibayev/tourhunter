<?php

namespace tests\unit\models;

use app\factories\UserFactory;
use app\models\User;
use app\services\BalanceService;

class BalanceServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var BalanceService
     */
    private $service;
    private $sender;
    private $reciever;

    protected function _before()
    {
        parent::_before();
        $this->service = new BalanceService();
        $this->sender = UserFactory::create('senderTest');
        $this->reciever = UserFactory::create('recieverTest');
    }

    public function testMoreMoneyThanICan()
    {
        $balance = 1001.00;
        $result  = $this->service->transfer($this->sender, $this->reciever, $balance);

        $this->assertFalse($result);
        $this->assertStringContainsString('User\'s balance can not be less than '.User::MIN_BALANCE, $this->service->getMessage());
    }

    public function testSendMoneyToMyself()
    {
        $balance = 99.99;
        $result  = $this->service->transfer($this->sender, $this->sender, $balance);

        $this->assertFalse($result);
        $this->assertStringContainsString('You can not send money to yourself.', $this->service->getMessage());
    }

    public function testSendNegativeBalance()
    {
        $balance = -1;
        $result  = $this->service->transfer($this->sender, $this->reciever, $balance);
        $this->assertFalse($result);
        $this->assertStringContainsString('You can not send negative value.', $this->service->getMessage());
    }

    public function testSuccessTransfer()
    {
        $balance = 99.99;
        $result  = $this->service->transfer($this->sender, $this->reciever, $balance);

        $this->assertTrue($result);
        $this->assertEquals(99.99, $this->reciever->balance);
        $this->assertEquals(-99.99, $this->sender->balance);
    }
}

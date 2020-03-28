<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \app\models\forms\MoneyTransferForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use \kartik\number\NumberControl;

$this->title                   = 'Transfer Money';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        You are about to send money to another user.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'method' => 'post']); ?>

            <?= $form->field($model, 'username')->textInput(['readonly' => true]) ?>
            <?= $form->field($model, 'amount')->widget(NumberControl::class, [
                'name'               => 'amount',
                'maskedInputOptions' => [
                    'prefix'     => '$ ',
                    'allowMinus' => false,
                ],
            ]) ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

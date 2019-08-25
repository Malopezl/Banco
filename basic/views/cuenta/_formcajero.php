<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <h2>Cuenta</h2>
    <?= Html::tag('h3', Html::encode($model->Nombre), ['class' => 'textfield']) ?>
    <h2>Saldo</h2>
    <?= Html::tag('h3', Html::encode($model->Saldo), ['class' => 'textfield']) ?>
    
    <?= $form->field($model, 'monto')->textInput() ?>

    <?php 
    $var = [0=>'Serializable', 1=> 'Repeteable Read', 2=> 'Read Committed', 3 => 'Read Uncommitted']; 
    echo $form->field($model, 'isolation')->dropDownList($var, ['prompt' => 'Seleccione Uno' ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Ejecutar'), ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

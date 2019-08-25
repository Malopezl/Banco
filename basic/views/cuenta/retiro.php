<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cuenta */

$this->title = 'Retiro' ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="cuenta-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_formretiro', [
        'model' => $model,
        'nombre' => $nombre
    ]) ?>

</div>

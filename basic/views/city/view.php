<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\City */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="city">

    <h4><?= Html::a(Html::encode($model->name), ['feedback/index', 'city' => $model->name]); ?></h4>

</div>

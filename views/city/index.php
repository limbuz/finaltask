<?php

use app\models\City;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <?php $session = Yii::$app->session;
    $session->timeout = 2* 3600;?>

    <?php

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim(end($ips));
    }
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $request = file_get_contents('http://ipwho.is/' . $ip . '?lang=ru');
    $request = json_decode($request, true);
    if ($request['success']) {
        $city = $request['city'];
    } else {
        $city = null;
    }
    ?>

    <?php if ($city !== null): ?>

        <?php Modal::begin([
                'options' => [
                    'id' => 'cityModal',
                    'style' => 'font-size: 20px; text-align: center'
                ],
                'size' => Modal::SIZE_SMALL
        ]); ?>

        <?= '<p>Ваш город: ' . $city . ' <img src=' . $request['flag']['img'] .' width="15" height="10" alt="">?</p>'; ?>

        <?= HTML::a("Да", ['feedback/index', 'city' => $city], ['class' => 'btn btn-primary', 'style' => 'margin-right: 5px', 'id' => 'yes']); ?>

        <?= HTML::button("Нет", ['class' => 'btn btn-primary', 'id' => 'no']); ?>

        <?php Modal::end(); ?>

        <?php if (!$session->has('city')): ?>

            <?php $this->registerJs("$('#cityModal').modal('show');
               $('#yes').click(() => { $('#cityModal').modal('hide'); });
               $('#no').click(() => { $('#cityModal').modal('hide'); })
            ") ?>

        <?php endif; ?>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest) {
        echo Html::a('Написать отзыв', ['feedback/create'], ['class' => 'btn btn-success']);
    } ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model) {
            return '<h4>' . Html::a(Html::encode($model->name), ['feedback/index', 'city' => $model->name]) . '</h4>';
        },
    ]) ?>


</div>

<?php
use yii\grid\GridView;
use app\models\WeatherGetByDate;
use app\models\WeatherGetHistory;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $weatherHistoryModel WeatherGetHistory */
/* @var $weatherGetByDateModel WeatherGetByDate */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>JSON-RPC-USER</h1>
        <p class="lead">Пользователь JSON-RPC Api</p>
    </div>

    <div>
        <?php
        $form = ActiveForm::begin([
                    'layout'      => 'horizontal',
                    'options'     => [
                        'class'        => 'alert alert-secondary pt-4',
                        'autocomplete' => 'off',
                    ],
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label'   => 'col-md-5 col-lg-3 col-form-label text-md-right',
                            'offset'  => 'offset-md-5 offset-lg-3',
                            'wrapper' => 'col-md-7 col-lg-9',
                            'field'   => 'form-group row mhf-4'
                        ],
                    ]
        ]);
        ?>

        <?= $form->errorSummary($weatherGetByDateModel); ?>
        <?= $form->field($weatherGetByDateModel, 'date')->textInput(['placeholder' => 'Например: 2021-01-01']); ?>
        <?php if (isset($weatherGetByDateModel->resultModel)): ?>
            <?= Html::encode("Температура {$weatherGetByDateModel->resultModel->temp} градусов") ?>
        <?php endif; ?>

        <hr/>

        <?=
        GridView::widget([
            'dataProvider' => $weatherHistoryModel->resultDataProvider,
            'columns'      => [
                'id', 'temp',
                [
                    'attribute' => 'date_at',
                    'format'    => 'date',
                ]
            ],
        ])
        ?>

        <div class="row">
            <div class="offset-md-5 offset-lg-3 col-md-7 col-lg-9">
                <?= Html::submitButton('Зпросить', ['class' => 'btn btn-danger btn-lg']); ?>
            </div>
        </div>

        <?php $form->end(); ?>
    </div>
</div>

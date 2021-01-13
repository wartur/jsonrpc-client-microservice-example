<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\WeatherGetHistory;
use app\models\WeatherGetByDate;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Признаюсь я тут время экономил.
     * Я просто пробросил результат API в датапровайдеры и все.
     * 
     * Можно было сделать проецирование в ActoveRecords-RPC, чтобы появилась ощущение будто бы мы с базой работаем
     * но если честно уже не хотел, а так конечно лучше это как ORM подключать юзая все по SOLID|DRY
     *
     * @return string
     */
    public function actionIndex()
    {
        $weatherHistoryModel = new WeatherGetHistory();
        $weatherHistoryModel->lastDays = 30;
        $weatherHistoryModel->execute();

        // немножко не правильно по POST-у что-либо отображать, поэтому корявенько, но в качестве примера пускай так будет
        $weatherGetByDateModel = new WeatherGetByDate();
        if (Yii::$app->request->isPost) {
            $weatherGetByDateModel->load(Yii::$app->request->post());
            $weatherGetByDateModel->execute();
        }

        return $this->render('index', [
                    'weatherHistoryModel'   => $weatherHistoryModel,
                    'weatherGetByDateModel' => $weatherGetByDateModel,
        ]);
    }

}

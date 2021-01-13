<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Datto\JsonRpc\Http\Client;
use yii\data\ArrayDataProvider;

/**
 * Description of WeatherGetByDate
 *
 * @author user
 */
class WeatherGetByDate extends \yii\base\Model
{

    public $date;

    /**
     *
     * @var WeatherHistory DTO с данными
     */
    public $resultModel = null;

    public function attributeLabels()
    {
        return [
            'date' => 'За какую дату запросить погоду?',
        ];
    }

    public function rules()
    {
        // рулсы специально не реализовывал и не валидировал для генерации ошибки на сервере
        return [['date', 'safe']];
    }

    /**
     * НАМЕРЕННО НЕ ВАЛИДИРУЮ входящий поток для того, чтобы можно было что хочешь отправить на API
     */
    public function execute()
    {
        try {
            $client = new Client('http://local.jsonserver/api'); // это чисто пример, возможно и через конфигурацию, а можно через IoC через переменную класса
            $client->query('weather-get-by-date', ['date' => $this->date], $response);
            $client->send();
            if ($response instanceof \Datto\JsonRpc\Responses\ErrorResponse) {
                if ($response->getCode() == -32603) {
                    // ошибку валидации пробрасываем к нам напрямую с JSON-SERVER-а
                    $this->addErrors($response->getData());
                    return false;
                } else {
                    // все другик ошибки считаем как Common
                    \Yii::error('Неизвестная ошибка API');
                    $this->addError('CommonError', 'API return: ' . $response->getMessage());
                    return false;
                }
            }
        } catch (\Exception $ex) {
            // если совсем беда, словим её указываем это в CommonError
            \Yii::error('Произошла проблема с сервером');
            $this->addError('CommonError', 'Exception: ' . $ex->getMessage());
            return false;
        }

        $this->resultModel = new WeatherHistory();
        $this->resultModel->setAttributes($response, false);

        return true;
    }

}

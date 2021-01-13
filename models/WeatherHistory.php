<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Простой DTO
 *
 * @author user
 */
class WeatherHistory extends \yii\base\Model
{

    public $id;
    public $temp;
    public $date_at;

    public function attributeLabels()
    {
        return [
            'temp'    => 'Температура',
            'date_at' => 'Дата',
        ];
    }

}

<?php namespace App\ACME\Helpers;

use GuzzleHttp;

/**
 * Class Mtt
 * @package App\ACME\Helpers
 *
 * Параметры доступа к новой версии сервиса CallBack:
 * Login: CallBack_Test
 * Password: 5udRA7ubuzEcUBru
 * Для агента cb_test открыт доступ к следующим обновленным функциям CAPI (в скобках указана ссылка на соотв.описание в Wiki):
 * setCallBackFollowme (http://wiki.mtt.ru/display/RNDWEBAPI/setCallBackFollowme)
 * setCallBackPrompt (http://wiki.mtt.ru/display/RNDWEBAPI/setCallBackPrompt)
 * getCallBackFollowme (http://wiki.mtt.ru/display/RNDWEBAPI/getCallBackFollowme)
 * makeCallBackCallFollowme (http://wiki.mtt.ru/pages/viewpage.action?pageId=20971793)
 * getCallBackFollowmeCallInfo (http://wiki.mtt.ru/display/RNDWEBAPI/getCallBackFollowmeCallInfo)
 * deleteCallBackFollowme (http://wiki.mtt.ru/display/RNDWEBAPI/deleteCallBackFollowme)
 * Варианты использования методов CallBack с учетом добавленных возможностей описаны в Wiki по адресу:
 * CallBack Use Cases (http://wiki.mtt.ru/display/RNDWEBAPI/CallBack+Use+cases)
 * Доступ к Wiki
 * guest/GuestAPI
 * Доступ к функциям осуществляется по протоколу HTTPS:
 * URL: https://webapicommon.mtt.ru/index.php (порт 443)
 * CAPI реализован в виде POST-запросов в соответствии со спецификацией JSON-RPC (http://www.jsonrpc.org/specification).
 * Все тесты проводятся с тестового именем customer_name: " 883140779001041".
 */
class Mtt{

    private $url="https://webapicommon.mtt.ru/index.php";

    static $id=1;


    /**
     * Данная функция позволяет получить данные для загрузки файла CallBack prompt.
     */
    function setCallBackPrompt($id)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'setFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'callBackFollowmeStruct'=>[
                    [
                        'order'=>1,
                        'timeout'=>10,
                        'type'=>'text',
                        'value'=>'Тестовый звонок от Goodline',
                        'side'=> 'A'
                    ],
                    [
                        'order'=>2,
                        'timeout'=>10,
                        'redirect_number'=>'79064207010',
                        'type'=>'Ringall',
                    ],

                    [
                        'order'=>3,
                        'timeout'=>20,
                        'redirect_number'=>'79064207010',
                        'type'=>'Ringall',
                    ],


                ],
                'defaultBNumber'=>env('MTT_default_number')
            ]
        ];
    }

    /**
     * Данная функция создает список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     */
    function setCallBackFollowme()
    {

    }



    /**
     * Данная функция позволяет получить список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     */
    function getCallBackFollowme()
    {

    }

    /**
     * Данная функция удаляет список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     */
    function deleteCallBackFollowme()
    {
    }

    /**
     * Данная функция осуществляет callback между А-номером или номерами, установленными в функции setCallBackFollowme или переданным в поле simpleCallBackFollowmeStruct  и B-номером.
     * Последовательность вызова определяется значением поля direction.
     * Для использования функции MakeCallbackFollowMe без предустановки SetCallBackFollowMe необходимо в обязательном порядке передавать параметр "simpleCallBackFollowmeStruct"
     */
    function makeCallBackCallFollowme()
    {

    }


    /**
     * Данная функция позволяет получить информацию об осуществленном CallBack вызове по его идентификатору.
     */
    function getCallBackFollowmeCallInfo()
    {

    }


}
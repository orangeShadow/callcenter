<?php namespace App\ACME\Helpers;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

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
class MttAPI{

    private $url="https://webapicommon.mtt.ru/index.php";

    static $id=1;

    public function __construct()
    {

    }

    /**
     * Данная функция позволяет получить данные для загрузки файла CallBack prompt.
     * @param $filename string
     * @return result stdObject
     */
    function setCallBackPrompt($filename)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'getCallBackFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'file_name' =>$filename
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }

    /**
     * Данная функция создает список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     * @param $defaultBNumber string Номер на который звонить в случае не дозвона на остальные номера
     * @param $phoneByOrder array массив номеров
     * @param $promo int Номер промо файла
     * @param $textA string текст на стороне заказчика
     * @param $textB string  текст на стороне клиента
     * @return result stdObject
     */
    function setCallBackFollowme($defaultBNumber,$phoneByOrder,$promo=false,$textA=null,$textB=null)
    {

        $callBackFollowmeStruct = [];



        $order = 1;

        if($promo!== false && $promo>0)
        {

        }

        if(!is_null($textA))
        {
            $callBackFollowmeStruct[]=[
                'order'=>$order,
                'timeout'=>10,
                'type'=>'text',
                'value'=>$textA,
                'side'=> 'A'
            ];
            $order++;
        }

        if(!is_null($textB))
        {
            $callBackFollowmeStruct[]=[
                'order'=>$order,
                'timeout'=>10,
                'type'=>'text',
                'value'=>$textA,
                'side'=> 'A'
            ];
            $order++;
        }

        if(is_array($phoneByOrder))
        {
            foreach($phoneByOrder as $phone){
                $callBackFollowmeStruct[] = [
                    'order'=>$order,
                    'timeout'=>20,
                    'redirect_number'=>$phone,
                    'type'=>'Ringall',
                ];
                $order++;
            }
        }

        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'setCallBackFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'callBackFollowmeStruct'=>$callBackFollowmeStruct,
                'defaultBNumber'=>$defaultBNumber
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }



    /**
     * Данная функция позволяет получить список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     *
     * @return result stdObject
     */
    function getCallBackFollowme()
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'getCallBackFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }

    /**
     * Данная функция удаляет список номеров, на которые будет осуществляться переадресация CallBack вызова, плечо А.
     *
     * @return result stdObject
     */
    function deleteCallBackFollowme()
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'deleteCallBackFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }

    /**
     * Данная функция осуществляет callback между А-номером или номерами, установленными в функции setCallBackFollowme или переданным в поле simpleCallBackFollowmeStruct  и B-номером.
     * Последовательность вызова определяется значением поля direction.
     * Для использования функции MakeCallbackFollowMe без предустановки SetCallBackFollowMe необходимо в обязательном порядке передавать параметр "simpleCallBackFollowmeStruct"
     *
     * @return result stdObject
     */
    function makeCallBackCallFollowme($b_number)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'makeCallBackCallFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'b_number'=>$b_number,
                'caller_id'=>'79094342294',
                'recordEnable'=>0,
                'duration'=>600,
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }


    /**
     * Данная функция позволяет получить информацию об осуществленном CallBack вызове по его идентификатору.
     */
    function getCallBackFollowmeCallInfo($callBackCall_id)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'makeCallBackCallFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'callBackCall_id'=>$callBackCall_id,
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post($this->url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result;
        }catch (RequestException $e)
        {
            echo $e->getRequest();
            if ($e->hasResponse()) {
                echo $e->getResponse();
            }
        }
    }


}
<?php namespace App\ACME\Helpers;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use App\ACME\Model\Callback\PhoneLog;
use Log;
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
 * MTT_login=CallBack_Test
 * MTT_password=5udRA7ubuzEcUBru
 * MTT_customer_name = 883140779001041
 */
class MttAPI{

    static protected $url="https://webapicommon.mtt.ru/index.php";

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
            'method'=>'setCallBackPrompt',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'file_name' =>$filename
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);

            $json = json_decode($res->getBody())->result;
            $client1 = new GuzzleHttp\Client();
            Log::alert('setCallBackPrompt');
            Log::info(json_encode($json));
            $res1 = $client1->post($json->uploadURL,
                [
                    'auth' => [env('MTT_login'), env('MTT_password')],
                    'verify'=>false,
                    'body'=>file_get_contents(public_path()."/audio/".$filename)
                ]);
            Log::info($res1->getBody());
            return json_decode($res1->getBody());
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                Log::error($e->getResponse()->getBody()->getContents());
                return $e->getResponse()->getBody()->getContents();
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
    function setCallBackFollowme($defaultBNumber,$phoneByOrder,$textA=null,$textB=null,$promoA=false,$promoB=false)
    {

        $callBackFollowmeStruct = [];



        $order = 1;

        if($promoA!== false)
        {
            $callBackFollowmeStruct[]=[
                'order'=>$order,
                'timeout'=>20,
                'type'=>'file',
                'value'=>$promoA,
                'side'=> 'A'
            ];
            $order++;
        }

        if($promoB!== false)
        {
            $callBackFollowmeStruct[]=[
                'order'=>$order,
                'timeout'=>20,
                'type'=>'file',
                'value'=>$promoB,
                'side'=> 'B'
            ];
            $order++;
        }

        /*
        if(!empty($textA) && $promoA==false)
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

        if(!empty($textB) && $promoB==false)
        {
            $callBackFollowmeStruct[]=[
                'order'=>$order,
                'timeout'=>10,
                'type'=>'text',
                'value'=>$textB,
                'side'=> 'B'
            ];
            $order++;
        }
        */

        if(is_array($phoneByOrder))
        {
            foreach($phoneByOrder as $phone){
                $callBackFollowmeStruct[] = [
                    'order'=>$order,
                    'timeout'=>120,
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

        Log::alert('setCallBackFollowme');
        Log::info(json_encode($request));

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            Log::info($res->getBody());
            return json_decode($res->getBody());
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                Log::error($e->getResponse()->getBody()->getContents());
                return $e->getResponse()->getBody()->getContents();
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
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody());
        }catch (RequestException $e)
        {
            return false;
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
        Log::alert('deleteCallBackFollowme');
        Log::info(json_encode($request));
        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            Log::info($res->getBody());
            return json_decode($res->getBody());
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                Log::error($e->getResponse()->getBody()->getContents());
                return $e->getResponse()->getBody()->getContents();
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
    function makeCallBackCallFollowme($b_number,$defaultPhone,$record=0)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'makeCallBackCallFollowme',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'b_number'=>$b_number,
                'client_caller_id'=>$b_number,
                'caller_id'=>$defaultPhone,
                'recordEnable'=>$record,
                'duration'=>600
            ]
        ];

        $client = new GuzzleHttp\Client();
        Log::alert('makeCallBackCallFollowme');
        Log::info(json_encode($request));
        try{
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            Log::info($res->getBody());
            return json_decode($res->getBody());
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                Log::error($e->getResponse()->getBody()->getContents());
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }


    /**
     * Данная функция позволяет получить информацию об осуществленном CallBack вызове по его идентификатору.
     */
    static  public function getCallBackFollowmeCallInfo($callBackCall_id)
    {
        $request = [
            'id'=>static::$id++,
            'jsonrpc'=>'2.0',
            'method'=>'getCallBackFollowmeCallInfo',
            'params'=>[
                'customer_name'=>env('MTT_customer_name'),
                'callBackCall_id'=>$callBackCall_id,
            ]
        ];

        $client = new GuzzleHttp\Client();
        try{
            $res = $client->post(static::$url, ['auth' => [env('MTT_login'), env('MTT_password')],'json'=>$request]);
            return json_decode($res->getBody())->result->callBackFollowmeCallInfoStruct;
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents());
            }
        }
    }



    static public function makeCall($client,$phone,PhoneLog $phoneLog = null)
    {
        $mtt = new self();
        $res=$mtt->getCallBackFollowme();

        if($res!==false)  $mtt->deleteCallBackFollowme();

        $phones = trim($client->settings->phones);
        $phones = empty($phones) ? [$client->settings->defaultPhone]:json_decode($client->settings->phones);
        $res   = $mtt->setCallBackFollowme($client->settings->defaultPhone,$phones,$client->settings->textA,$client->settings->textB,!empty($client->settings->audioIdA) ? $client->settings->audioIdA:false,!empty($client->settings->audioIdB) ? $client->settings->audioIdB:false);
        $resCall = $mtt->makeCallBackCallFollowme($phone,$client->settings->defaultPhone,$client->settings->record);
        $res = $mtt->deleteCallBackFollowme();
        $result = [];
        if(!empty($resCall->result->callBackCall_id)){
            $phoneLog->setAttribute('call_id',$resCall->result->callBackCall_id);
            $phoneLog->save();
            $result = $resCall;
            //$result["success"]="y";
            //$result["call_id"]=$resCall->result->callBackCall_id;
        }else{
            $result["success"]="n";
        }

        return $result;
    }
}
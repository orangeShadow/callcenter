<?php
namespace App\ACME\Helpers;
class CRMHelper{

    /**
     * Отправка заявки в CRM
     *
     * @param $questionID
     * @param $questionType
     * @param $questionDirection
     * @param $params  array ["comment"=>,"fio"=>,"phone"=>,"email"=>]
     * @return mixed
     */
    static public function sendClaim($questionID,$questionType,$questionDirection,$params)
    {
        $object  = new \stdClass();
        $object->Questions = array();

        $question = new \stdClass();
        $question->questionID = $questionID;
        $question->questionType = $questionType;
        $question->questionDirection = $questionDirection;

        if(!empty($params["comment"]))
        {
            $question->questionComment =$params["comment"];
        }


        $object->Questions[] = $question;

        $object->countryId= 1;
        $object->statusId = 1;
        $object->abonTypeId  = 2;
        $object->username="bitrix-site";

        $object->contactData = array(
            array('name'=>'372','id'=>1)
        );

        if(!empty($params["fio"]))
        {
            $object->contactData[]=array('name'=>$params["fio"],'id'=>3);
        }

        if(!empty($params["email"]))
        {
            $object->contactData[]=array('name'=>$params["email"],'id'=>4);
        }

        if(!empty($params["phone"]))
        {
            $object->contactData[]=array('name'=>$params["phone"],'id'=>2);
        }


        $post_q['query'] = json_encode($object);
        $post = http_build_query($post_q);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, env("CRM_url"));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

        $out = curl_exec($curl);
        return $out;
    }
}
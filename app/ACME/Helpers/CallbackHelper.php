<?php
namespace App\ACME\Helpers;

use \Request;

class CallbackHelper {
    private $colors=[
        1=>"#009321",
        2=>"#FED440",
        3=>"#cba0e8",
        4=>"#a7caea",
        5=>"#d4d752",
        6=>"#ededed",
        7=>"#e5dc8f",
        8=>"#ae6467",
        9=>"#BF00E1",
        10=>"#7a0093"
    ];

    /**
     * Css для иконки и форм звонка
     * @param $client
     * @return mixed|string css
     */
    private function getFormCss($client,$name)
    {
        $colors = empty($client->settings->colors) ? 1: ($client->settings->colors);
        $top = empty($client->settings->top) ? "20%": ($client->settings->top)."%";
        $right = empty($client->settings->right) ? "10px": ($client->settings->right)."px";
        $color = empty($client->settings->color_code) ? static::getColorScheme($colors): "#".$client->settings->color_code;
        $button_size = !empty($client->settings->button_size) ? $client->settings->button_size : 60;



        $server = "http://".$_SERVER['SERVER_NAME'];
        $css = file_get_contents(base_path()."/public/css/callback/$name.css");
        $css = preg_replace('/\[color2\]/','#566473',$css);
        $css = preg_replace('/\[button_size\]/',$button_size,$css);
        $css = preg_replace('/\[button_size_half\]/',-round($button_size/2),$css);
        $css = preg_replace('/\[color\]/',$color,$css);
        $css = preg_replace('/\[top\]/',$top,$css);
        $css = preg_replace('/\[right\]/',$right,$css);
        $css = preg_replace('/\[server\]/',$server,$css);
        return $css;
    }

    /**
     * Css для иконки и форм звонка
     * @param $client
     * @return mixed|string js
     */
    private function getFormJS($client,$style,$html,$name)
    {
        $key = $client->key;
        $colors = empty($client->settings->colors) ? 1: ($client->settings->colors);
        $color  = empty($client->settings->color_code) ? static::getColorScheme($colors): "#".$client->settings->color_code;
        $url = ($name=="callform") ? url('externcall'):url('formback');

        $yandex_cn = empty($client->settings->yandex_cn) ? "undefined":$client->settings->yandex_cn ;
        $yandex_goal = empty($client->settings->yandex_goal) ? "undefined":$client->settings->yandex_goal ;

        $swe = empty($client->settings->swe_interval) ? 60000: ($client->settings->swe_interval*1000);
        $sop = empty($client->settings->sop_interval) ? 90000: ($client->settings->sop_interval*1000);
        $site_time =  empty($client->settings->site_time) ? "undefined":$client->settings->site_time ;
        $page_count = empty($client->settings->page_count) ? "undefined":$client->settings->page_count ;
        $client_count_show = empty($client->settings->client_count_show) ? "undefined":$client->settings->client_count_show ;
        $visit_count  = empty($client->settings->visit_count) ? "undefined":$client->settings->visit_count ;

        $content = file_get_contents(base_path()."/public/js/callback/$name.js");
        $content = preg_replace('/\[key\]/',$key,$content);
        $content = preg_replace('/\[style\]/',$style,$content);
        $content = preg_replace('/\[html\]/',addslashes($html),$content);
        $content = preg_replace('/\[color\]/',$color,$content);

        $content = preg_replace('/\[url\]/',$url,$content);
        $content = preg_replace('/\[yandex_cn\]/',$yandex_cn,$content);
        $content = preg_replace('/\[yandex_goal\]/',$yandex_goal,$content);

        $content = preg_replace('/\[swe\]/',$swe,$content);
        $content = preg_replace('/\[sop\]/',$sop,$content);
        $content = preg_replace('/\[site_time\]/',$site_time,$content);

        $content = preg_replace('/\[page_count\]/',$page_count,$content);
        $content = preg_replace('/\[client_count_show\]/',$client_count_show,$content);
        $content = preg_replace('/\[visit_count\]/',$visit_count,$content);

        return $content;
    }

    /**
     * Html для иконуи и форм
     * @param $name
     * @return html
     */
    private function getFormHtml($name){
        $content = file_get_contents(base_path()."/public/html/callback/$name.html");
        return $content;
    }

    /**
     * Получаем цвет
     * Надстройка можно переделать на БД
     *
     * @param $colorScheme
     * @return mixed
     */
    private function getColorScheme($colorScheme)
    {
        return $this->colors[$colorScheme];
    }

    public function getColors()
    {
        return $this->colors;
    }


    /**
     * Форма обратного звонка
     * @param $client
     * @return string
     */
    public function getCallBackForm($client)
    {

        $style= "<style>".$this->getFormCss($client,'callform')."</style>";
        $html = $this->getFormHtml('callform');
        $result = $this->getFormJS($client,$style,$html,'callform');
        return $result;
    }

    /**
     * Форма сообщения с сайта
     * @param $client
     * @return string
     */
    public function getSendBackForm($client)
    {
        $style= "<style>".$this->getFormCss($client,'backform')."</style>";
        $html = $this->getFormHtml('backform');
        $result = $this->getFormJS($client,$style,$html,'backform');
        return $result;
    }

}
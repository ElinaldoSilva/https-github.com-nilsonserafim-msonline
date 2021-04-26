<?php

namespace App\Helpers;

class Helper
{
    public static function uniqueidentifier()
    {
        //  Cria o Chaves Únicas para Id 
        //
        if (function_exists('com_create_guid')) {
            $painelId=com_create_guid();
        } else{
            mt_srand((double)microtime()*10000);        
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);          // "-"
            $painelId = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);      // "}"
        }

        return strtoupper($painelId);
    }

    //  Para utilizar: na View, colocar  {!! Helper::uniqueidentifier() !!}   ou
    //                 no Controller, colocar "user Helper"  e  na class:    Helper::uniqueidentifier()
    //
    //  Veja exemplo em HomeController.php

}
<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 12/20/19
 * Time: 2:41 PM
 */

namespace Serbinario\Traits;


trait UtilEntities
{

    function convertesRealIngles($value){
        $var = str_replace(".","",$value);
        return str_replace(",",".",$var);
    }

    function converteInglesReal($value){
        return number_format($value,2,",",".");
    }
}
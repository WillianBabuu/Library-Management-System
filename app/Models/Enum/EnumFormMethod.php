<?php

namespace App\Models\Enum;

class EnumFormMethod {
    private static $enumFormMethod_list = array(
        'SAVE'=>array('value'=>'save','description'=>'Save'),
        'UPDATE'=>array('value'=>'update','description'=>'Update'),
        'UPDATE_ONE_FIELD'=>array('value'=>'update_one_field','description'=>'Update'),
        'DELETE'=>array('value'=>'delete','description'=>'Delete'),
        'POST'=>array('value'=>'post','description'=>'Post'),
        'GET'=>array('value'=>'get','description'=>'Get'),
    );

    public static function get($path = null) {
        if($path){
            $enumFormMethod = self::$enumFormMethod_list;
            $path = explode('/', $path);

            foreach($path as $bit) {
                if (isset($enumFormMethod[$bit])){
                    $enumFormMethod = $enumFormMethod[$bit];
                }
            }

            return $enumFormMethod;
        }

        return null;
    }
}

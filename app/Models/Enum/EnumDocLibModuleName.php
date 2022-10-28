<?php

namespace App\Models\Enum;

class EnumDocLibModuleName {
    private static $enumFormMethod_list = array(
        'COMPANY_LOGO'=>array('value'=>'1','description'=>'Save'),
        'PROFILE_PICTURE'=>array('value'=>'2','description'=>'Update'),
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

<?php
namespace App\Util;

class JsonResponse {
    public static $OK = "OK";
    public static $ERROR = "ERROR";

    public static function get($status, $errorMessage, $returnData = null){
        return array(
            'status' => $status,
            'errorMessage' => $errorMessage,
            'returnData' => $returnData,
        );
    }

    public static function validationErrorMessage($validator){
        $errors = array();
        $messages = $validator->errors();
        foreach($messages->all() as $message){
            array_push($errors, $message);
        }
        return JsonResponse::get("ERROR", "Validation Error", array("errors"=>$errors));
    }
}

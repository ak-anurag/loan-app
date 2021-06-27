<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AppKey extends Model
{
    use HasFactory;

    //check api
    public static function isApiValid(string $apiKey){
        $validator = Validator::make(['apikey' => $apiKey], ['apikey' => ['required', 'string', 'alpha_num']]);
        if($validator->fails()){
            return false;
        }

        $isApi = self::where(['api_key' => $apiKey, 'status' => 1])->first();
        if(!isset($isApi) || $isApi == ''){
            return false;
        }

        return true;
    }
}

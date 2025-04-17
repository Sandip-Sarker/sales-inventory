<?php


namespace App\Http\Helper;


use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    function createToken($userEmail)
    {
        $key = env('JWT_KEY');
        $payload=[
            'token_iss_name'    =>'Laravel-token',
            'token_create_time' => time(),
            'token_expire_time' =>time()+60*60,
            'user_email'        => $userEmail
        ];

        return $encode = JWT::encode($payload, $key, 'HS256');
    }


    function verifyToken($token)
    {
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));

            return $decode->user_email;
        }catch (Exception $e){
            return 'Unauthorize';
        }
    }
}

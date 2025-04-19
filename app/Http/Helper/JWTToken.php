<?php


namespace App\Http\Helper;


use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function createToken($userEmail, $userId)
    {
        $key = env('JWT_KEY');
        $payload=[
            'token_iss_name'    =>'Laravel-token',
            'token_create_time' => time(),
            'token_expire_time' =>time()+60*60,
            'user_email'        => $userEmail,
            'user_id'           => $userId
        ];

        return $encode = JWT::encode($payload, $key, 'HS256');
    }

    public static function createTokenForSetPassowrd($userEmail)
    {
        $key = env('JWT_KEY');
        $payload=[
            'token_iss_name'    =>'Laravel-token',
            'token_create_time' => time(),
            'token_expire_time' =>time()+60*20,
            'user_email'        => $userEmail,
            'user_id'           => '0'
        ];

        return $encode = JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyToken($token)
    {
        try {
            if ($token == null)
            {
                return 'Unauthorized';
            }
            else {

                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }

        }catch (Exception $e){
            return 'Unauthorized';
        }
    }
}

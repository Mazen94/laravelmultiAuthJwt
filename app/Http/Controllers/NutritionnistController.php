<?php

namespace App\Http\Controllers;

use App\Nutritionnist;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use Config;
class NutritionnistController extends Controller
{

    public function register(Request $request){

        //si c'est pas le cas donc on cree un user
        Nutritionnist::Create([
                         'email' => $request->get('email'),
                         'password' => bcrypt($request->get('password'))
                     ]);

        //on l 'ajoute a la variable user
        $user = Nutritionnist::first();

        //on lui donne la token
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));

    }


    public function login(Request $request){

        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                                            'response' => 'error',
                                            'message' => 'invalid_email_or_password',
                                        ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                                        'response' => 'error',
                                        'message' => 'failed_to_create_token',
                                    ]);
        }
        return response()->json([
                                    'response' => 'success',
                                    'result' => [
                                        'token' => $token,
                                        'message' => 'I am Admin user',
                                    ],
                                ]);
    }
}

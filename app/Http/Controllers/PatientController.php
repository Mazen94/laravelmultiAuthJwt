<?php

namespace App\Http\Controllers;


use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use JWTAuthException;
use Config;

class PatientController extends Controller
{
    //
    public function register(Request $request){

        //si c'est pas le cas donc on cree un user
        Patient::Create([
                                  'email' => $request->get('email'),
                                  'password' => bcrypt($request->get('password'))
                              ]);

        //on l 'ajoute a la variable user
        $user = Patient::first();

        //on lui donne la token
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));

    }


    public function login(Request $request){


        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token =auth('api-patient')->attempt($credentials)) {
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
                                        'token' =>$token ,
                                        'message' => 'I am  patient',
                                    ],
                                ]);
    }
}

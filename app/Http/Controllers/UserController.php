<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerifyRequest;
use App\Http\Requests\EmailVerifyReSentRequest;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserSendCodeRequest;
use App\Http\Resources\ResponseBase\ErrorResponse;
use App\Http\Resources\ResponseBase\SuccessEmptyResponse;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Http\Resources\UserRegisterVerifyResource;
use App\Mail\UserAuthMail;
use App\Mail\UserRegisterMail;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Str;

class UserController extends Controller
{
    public function sendCode(UserSendCodeRequest $request)
    {
        $code = rand(000000, 999999);
        if ($user = User::firstWhere('email', '=', $request->get('email'))) {

            $user->update(['code' => $code ]);

            Mail::to($request->get('email'))->send(new UserAuthMail($code));
        } else {
            User::create([
                'email' => $request->get('email'),
                'code' => $code
            ]);
            Mail::to($request->get('email'))->send(new UserRegisterMail($code));
        }

        return SuccessEmptyResponse::make('Email sent');
    }
    public function auth(UserAuthRequest $request)
    {
        
        if ($user = User::firstWhere($request->validated())) {
            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
            }

            $user->code = '';

            $user->save();

            $token = $user->createToken('user')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return SuccessResponse::make(UserRegisterVerifyResource::make($response), 'Email Success Verified');
        }

        return ErrorResponse::make('Code incorrect');

    }
}

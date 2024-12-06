<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVerifyRequest;
use App\Http\Requests\EmailVerifyReSentRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\ResponseBase\ErrorResponse;
use App\Http\Resources\ResponseBase\SuccessEmptyResponse;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Http\Resources\UserRegisterVerifyResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Str;

class UserController extends Controller
{
    public function auth(UserRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->get('email'),
            'hash' => Str::random(32)
        ]);

        event(new Registered($user));
    }
    public function registerVerify(EmailVerifyRequest $request)
    {
        if ($user = User::query()->firstWhere('hash', '=', $request->get('hash'))) {
            if (! $user->email_verified_at) {
                $user->update([
                    // 'email_verified_at' => now(),
                    // 'hash' => ''
                ]);

                $token = $user->createToken('user')->plainTextToken;

                $response = [
                    'user' => $user,
                    'token' => $token
                ];

                return SuccessResponse::make(UserRegisterVerifyResource::make($response), 'Email Success Verified');
            }

            return ErrorResponse::make('Email alredy verified');
        } 

        return ErrorResponse::make('Verify Error');
    }
    public function registerVerifyReSent(EmailVerifyReSentRequest $request)
    {
        $user = User::firstWhere('email', '=', $request->get('email'));
        event(new Registered($user));
    }

    public function test()
    {
        // Mail::to('qiuopa@gmail.com')->send()
    }
}

<?php

namespace App\Http\Controllers;
use App\Image;
use App\Traits\ImageUpload;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\VerifyEmailRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Cache;

class UserController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(StoreRequest $request,$id)
    {        
        $user = User::where(['invitation_token' => $id])->first();
        if($user != null)
        {
            if($user->registered_at == null)
            {
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->registered_at = time();
                $user->update();
               if($user->registered_at != null)
               {
                   $this->sendOtp($user->username,$user->email);
                return response()->json(['message' => 'Registered successfully, please verify your email'],201);
               }
               else{
                $this->sendOtp($user->username,$user->email);
                   return response()->json(['message' => 'Something went wrong'],404);
               }
            }
            else if($user->registered_at != null && !$user->email_verified  )
            {
                $this->sendOtp();
                return response()->json(['message' => 'You are already registered! please verify your email'],200);
            }
            else{
                return response()->json(['message' => 'You are already registered'],404);
            }
           
           
        }
        else{
            return response()->json(['message' => 'Not found'],404);
        }
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {        
        if(Cache::get($request->username) == $request->otp)
        {
            $user = User::where(['username' => $request->username])->update(['invitation_token' => null,'email_verified'=>true ]);
            if($user)
            {
                Cache::forget($request->username);
                return response()->json(['message' => 'Verify Successfully'],200);

            }
            else{
                return response()->json(['message' => 'Something went wrong'],404);
            }
        }
        else{
            return response()->json(['message' => 'Incorrect Otp'],404);
        }
    }

    public function update(UpdateRequest $request)
    {        
        auth()->user()->update($request->validated());
        return $this->userResource(auth()->getToken()->get());
    }


    public function show()
    {
        return $this->userResource(auth()->getToken()->get());
    }

    public function login(LoginRequest $request)
    {
        if ($token = auth()->attempt($request->validated())) {
            return $this->userResource($token);
        }
        return response()->json(['message' => 'Invalid email or password'],401);
    }

    protected function userResource(string $jwtToken)
    {
        if(auth()->user()->email_verified)
        {
            return ['user' => ['token' => $jwtToken] + auth()->user()->toArray()];

        }
        else{
            return ['message' => 'Verify your email'];
        }
    }

    protected function sendOtp(string $username,string $email) : bool
    {
        $otp = random_int(99999,999999);
        error_log($otp);
        Cache::add($username, $otp);
        return true; 
    }
}

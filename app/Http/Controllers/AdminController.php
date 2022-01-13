<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\InvitationRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
class AdminController extends Controller
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(StoreRequest $request)
    {
        $user = $this->user->create($request->validated());
        return response()->json(['message' => 'Register Successfully']);
        return $this->userResource(auth()->refresh());
    }

    public function login(LoginRequest $request)
    {
        if ($token = auth()->attempt($request->validated())) {
            return $this->userResource($token);
        }
        return response()->json(['message' => 'Invalid email or password'],200);
    }

    public function sendInvitationToUser(InvitationRequest $request)
    {
        $user = User::where(['email' => $request->email,'registered_at'=>null])->first();
        error_log($user);
        if(!$user)
        {
            $this->user->create(['email' => $request->email,'invitation_token' => $request->email]);
        }
        else{
            if($user->registered_at == null)
            {
                return response()->json(['message' => 'Invitation send successfully']);
            }
            else{
                return response()->json(['message' => 'User already registered']);
            }
        }
       
    }

    protected function userResource(string $jwtToken): array
    {
        return  ['token' => $jwtToken] + auth()->user()->toArray();
    }
}

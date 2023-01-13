<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UserLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Triats\HttpResponse;
class AuthController extends Controller
{
    use HttpResponse;
    public function register(StoreUser $storeUser)
    {
        $storeUser->validated($storeUser->all());
        $user = User::create([
            'name'=>$storeUser->username,
            'email'=>$storeUser->email,
            'password'=>Hash::make($storeUser->password)

        ]);
        return $this->seccuss($user, ['token'=>$user->createToken('auth_token')->plainTextToken]);

    }
    public function login(UserLogin $userLogin)
    {
        $userLogin->validated($userLogin->all());
        if (!Auth::attempt($userLogin->only('email', 'password'))) {
            return $this->erorr('Wrong cordantion', null, 401);
        }
        $user = User::where('email', $userLogin['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;


       return $this->seccuss([
            'user'=>$user,
            'token'=>$token
        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
    }
}

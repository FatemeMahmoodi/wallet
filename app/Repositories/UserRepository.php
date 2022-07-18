<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     *
     *
     * @param array $input
     * @return \stdClass
     */
    public function signUp(array $input): \stdClass
    {
        $user = User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $output = new \stdClass();
        $output->user = $user;
        $output->token = $user->createToken('MyApp')->accessToken;
        return $output;
    }

    /**
     * Undocumented function
     *
     * @param array $input
     * @return \stdClass
     * @throws AuthenticationException
     */
    public function signIn(array $input): \stdClass
    {
        $login = Auth::attempt($input);
        if (!$login) {
            throw new AuthenticationException(__('messages.wrongNameOrPassword'));
        }
        $user = Auth::user();
        $output = new \stdClass();
        $output->user = $user;
        $output->token = $user->createToken('MyApp')->accessToken;
        return $output;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function currentUser()
    {
        return Auth::user();
    }

    public function update(int $userId, array $data)
    {
        $user = User::findOrFail($userId);
        if (isset($data['password']))
            $data['password'] = Hash::make($data['password']);
        return $user->update($data);
    }

    /**
     * @return bool
     */
    public function signOut(): bool
    {
        Auth::user()->token()->revoke();
        return true;
    }


}

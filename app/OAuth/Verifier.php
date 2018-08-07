<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 28/04/17
 * Time: 16:52
 */

namespace Prominas\OAuth;

use Illuminate\Support\Facades\Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}
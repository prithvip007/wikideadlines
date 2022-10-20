<?php

namespace App;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;

class UserTokenAuth
{

    static private function getKey(): string
    {
        return config('app.auth_by_link_key', '');
    }

    static private function getUserId(string $jwt): ?int
    {
        try {
            $decoded = JWT::decode($jwt, new Key(self::getKey(), 'HS256'));

            $userId = $decoded->user->id;

            return $userId;
        } catch (\Exception $e) {
            return null;
        }
    }

    static public function authenticateByToken(string $jwt): void
    {
       $userId = self::getUserId($jwt);

       if ($userId === null) {
           return;
       }

       if (Auth::user()) {
           return;
       }

       $user = User::find($userId);

       $guard = Auth::guard();

       $guard->login($user);
    }

    static public function getTokenForUser(User $user, int $expirationMinutes): string
    {
        $payload = array(
            "iss" => config('app.url'),
            "aud" => config('app.url'),
            "iat" => now()->getTimestamp(),
            "exp" => now()->addMinutes($expirationMinutes)->getTimestamp(),
            "user" => [ 'id' => $user->id ]
        );
    
        return JWT::encode($payload, self::getKey(), 'HS256');
    }

    static public function getAuthLink(User $user, ?string $redirectURL): string
    {
        $token = self::getTokenForUser($user, 4320);

        return route('auth.token', [ 'jwt' => $token, 'redirectURL' => $redirectURL ?? '' ]);
    }
}

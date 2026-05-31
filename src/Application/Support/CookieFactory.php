<?php

namespace App\Application\Support;

class CookieFactory
{
    public static function session(string $token): string
    {
        return sprintf(
            'session_token=%s; Path=/; HttpOnly; SameSite=Lax; Max-Age=%d',
            $token,
            604800
        );
    }

    public static function destroy(): string
    {
        return 'session_token=; Path=/; HttpOnly; Max-Age=0';
    }
}

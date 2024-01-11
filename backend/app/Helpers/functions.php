<?php

use Illuminate\Support\Str;

if (! function_exists('mask_email')) {
    function mask_email(string $email): string
    {
        $login = Str::before($email, '@');
        $domain = Str::after($email, '@');

        $login = substr_replace($login, str_repeat('*', strlen($login) - 2), 2, strlen($login) - 2);

        return $login.'@'.$domain;
    }
}

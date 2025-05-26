<?php

namespace Modules\Server\Services\Auth;

/**
 * @author narnowin195@gmail.com
 */
interface AuthImplement
{
    public function login($username, $password);

    public function refreshToken();

    public function logout();
}

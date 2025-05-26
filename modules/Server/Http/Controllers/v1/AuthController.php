<?php

namespace Modules\Server\Http\Controllers\v1;

use App\ServerResponse;
use App\TransmedicControllerApp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Server\Http\Request\V1\LoginRequest;
use Modules\Server\Services\Auth\AuthImplement;
use function App\success;

/**
 * @author narnowin195@gmail.com
 */
class AuthController extends  TransmedicControllerApp
{
    protected AuthImplement $authImplement;

    public function __construct(AuthImplement $authImplement)
    {
        $this->authImplement = $authImplement;
    }

    /**
     * @unauthenticated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->only('username', 'password');
        $response = $this->authImplement->login(username: $data['username'], password: $data['password']);

        return success(message: ServerResponse::SUCCESS, resource: ['data' => $response]);
    }

    public function refresh() :JsonResponse
    {
        $token = $this->authImplement->refreshToken();

        return success(message: ServerResponse::SUCCESS, resource: $token);
    }

    public function logout(): JsonResponse
    {
        $this->authImplement->logout();
        $data = [];
        return success(ServerResponse::SUCCESS, $data);
    }
}

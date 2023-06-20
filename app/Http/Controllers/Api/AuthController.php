<?php

namespace App\Http\Controllers\Api;

use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\LogoutRequest;
use App\Interfaces\Eloquent\IAuthService;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class AuthController extends Controller
{
    use HttpResponse;

    /**
     * @var IAuthService
     */
    private IAuthService $authService;

    /**
     * @param IAuthService $authService
     */
    public function __construct(IAuthService $authService)
    {
         $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = $this->authService->login($request->email, $request->password);
        return $this->httpResponse(
            $response->isSuccess(),
            $response->getMessage(),
            $response->getData(),
            $response->getStatusCode()
        );
    }

    /**
     * @return JsonResponse
     * @param LogoutRequest $request
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $response = $this->authService->logout();
        return $this->httpResponse(
            $response->isSuccess(),
            $response->getMessage(),
            $response->getData(),
            $response->getStatusCode()
        );
    }
}

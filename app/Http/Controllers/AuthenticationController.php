<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Responses\ResponsesInterface;
use App\Models\User;
use App\Transformers\CustomDataSerializer;
use App\Transformers\UsersTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Fractal\Fractal;

class AuthenticationController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    protected ResponsesInterface $responder;

    /**
     * AuthenticationController constructor.
     * @param ResponsesInterface $responder
     */
    public function __construct(ResponsesInterface $responder)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->responder = $responder;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = Auth::attempt($request->only('email', 'password')))
            return $this->responder->respondAuthenticationError();

        return $this->responder->respond([
            'user' => Fractal::create(Auth::user(), new UsersTransformer(), CustomDataSerializer::class)->toArray(),
            'authorization' => ['type' => 'bearer', 'token' => $token]
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->only('name', 'email', 'password'));

        return $this->responder->respond([
            'user' => Fractal::create($user, new UsersTransformer(), CustomDataSerializer::class)->toArray(),
            'authorization' => ['type' => 'bearer', 'token' => Auth::login($user)]
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return $this->responder->respond(['message' => 'You have been successfully logged out.']);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->responder->respond([
            'user' => Fractal::create(Auth::user(), new UsersTransformer(), CustomDataSerializer::class)->toArray(),
            'authorization' => ['type' => 'bearer', 'token' => Auth::refresh()]
        ]);
    }
}

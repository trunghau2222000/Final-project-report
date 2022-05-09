<?php

namespace App\Modules\User\Services;

use App\Helpers\TransformerResponse;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Modules\User\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{

    private $transformerResponse;
    private $userRepository;
    const LOGIN_SUCCESS = 'Logged in successfully';
    const LOGIN_FAILED  = 'Login failed';

    public function __construct(
        TransformerResponse $transformerResponse,
        UserRepositoryInterface $userRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->userRepository      = $userRepository;
    }

    /**
     * register user
     * @param $request
     * @return reponse
     */
    public function register($request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = bcrypt($validated['password']);
            $data = $validated;
            // create User
            $user = $this->userRepository->create($data);
            return $this->transformerResponse->response(
                false,
                [
                    'user' => $user
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::CREATE_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }

    }

    /**
     * login user
     * @param $request
     * @return reponse
     */
    public function login($request)
    {
        try {
            $validated = $request->only('username', 'password');
            if (Auth::attempt($validated)) {
                $user = auth()->user();
                $token = Auth::user()->createToken('trunghau')->accessToken;
                return $this->transformerResponse->response(
                    false,
                    [
                        'user' => $user,
                        'token' => $token,
                    ],
                    TransformerResponse::HTTP_OK,
                    self::LOGIN_SUCCESS
                );
            }

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_OK,
                self::LOGIN_FAILED
            );

        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    /**
     * Get current user
     * @return reponse
     */
    public function getCurrentUser()
    {
        try {
            $user = auth()->user();
            return $this->transformerResponse->response(
                false,
                [
                    'user' => $user
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }
}

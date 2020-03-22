<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsersRequest;
use App\Repositories\UsersRepository;
use Exception;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    /**
     *
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    /**
     * @param UsersRequest $request
     * @return void
     */
    public function store(UsersRequest $request)
    {
        try {
            $user = $this->usersRepository->create($request->all());
            if ($user !== null) {
                $token = $user->createToken($request->name . time())->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'user' => $user,
                ], Response::HTTP_CREATED);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }
}

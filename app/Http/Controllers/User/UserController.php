<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Service\User\UseCase as UserService;
use App\Util\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller {

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllUser()
    {
        $listUser = $this->userService->getAllUser();
        $data = Common::convertListUserModelToPresenter($listUser);
        $response = [
            'status' => strval(Response::HTTP_OK),
            'message' => 'SUCCESS',
            'results' => $data
        ];

        return response()->json($response);
    }

    public function getUserById(Request $request)
    {
        $id = (int)($request->query('id'));

        $user = $this->userService->getUserById($id);
        if (!$user) {
            return ExceptionHandler::HandleException(Response::HTTP_BAD_REQUEST, 'Bad request');
        }

        $data = Common::convertUserToPresenterWithoutId($user);
        $response = [
            'status' => strval(Response::HTTP_OK),
            'message' => 'SUCCESS',
            'results' => $data
        ];

        return response()->json($response);
    }
}
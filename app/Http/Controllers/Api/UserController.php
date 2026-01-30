<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use App\Traits\ResponseTrait;

class UserController extends Controller
{
    use ResponseTrait;

    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return $this->successWithDataResponse($users);
        } catch (\Exception $e) {
            return $this->failureResponse('فشل في جلب المستخدمين');
        }
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);

            return $this->successWithDataResponse($user);
        } catch (\Exception $e) {
            return $this->failureResponse('فشل في جلب المستخدم');
        }
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return $this->successWithDataResponse($user);
        } catch (\Exception $e) {
            return $this->failureResponse('فشل في إنشاء المستخدم');
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return $this->successWithDataResponse($user);
        }catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage (soft delete).
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return $this->successResponse('تم حذف المستخدم بنجاح');
            }catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}


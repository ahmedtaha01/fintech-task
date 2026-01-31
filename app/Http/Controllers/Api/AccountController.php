<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\Account\AccountResource;
use App\Services\AccountService;
use App\Services\UserService;
use App\Traits\ResponseTrait;

class AccountController extends Controller
{
    use ResponseTrait;

    /**
     * The account service instance.
     *
     * @var AccountService
     */
    protected AccountService $accountService;

    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService
    * @param UserService $userService
     */
    public function __construct(AccountService $accountService, UserService $userService)
    {
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the accounts for a user.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($userId)
    {
        try {
            $accounts = $this->accountService->getAllAccounts($userId);
            return $this->successWithDataResponse(AccountResource::collection($accounts));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Display the specified account.
     *
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userId, $accountId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $accountModel = $this->accountService->getAccountById($accountId);

            $this->accountService->verifyAccountOwnership($accountModel, $userId);

            return $this->successWithDataResponse(new AccountResource($accountModel));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created account in storage.
     *
     * @param StoreAccountRequest $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAccountRequest $request, $userId)
    {
        try {
            $account = $this->accountService->createAccount($request->validated(),$userId);

            return $this->successWithDataResponse(new AccountResource($account));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Update the specified account in storage.
     *
     * @param UpdateAccountRequest $request
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request, $userId, $accountId)
    {
        try {
            $accountModel = $this->accountService->getAccountById($accountId);

            $this->accountService->verifyAccountOwnership($accountModel, $userId);

            $accountModel = $this->accountService->updateAccount($accountId, $request->validated());
            return $this->successWithDataResponse(new AccountResource($accountModel));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified account from storage (soft delete).
     *
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($userId, $accountId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $accountModel = $this->accountService->getAccountById($accountId);

            $this->accountService->verifyAccountOwnership($accountModel, $userId);

            $this->accountService->deleteAccount($accountId);
            return $this->successResponse('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}


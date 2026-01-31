<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\User;
use App\Services\AccountService;
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
     * Create a new controller instance.
     *
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Display a listing of the accounts for a user.
     *
     * @param int $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user)
    {
        try {
            $accounts = $this->accountService->getAllAccounts($user);
            return $this->successWithDataResponse($accounts);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Display the specified account.
     *
     * @param int $user
     * @param int $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user, $account)
    {
        try {
            $accountModel = $this->accountService->getAccountById($account);

            $this->accountService->verifyAccountOwnership($accountModel, $user);

            return $this->successWithDataResponse($accountModel);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created account in storage.
     *
     * @param StoreAccountRequest $request
     * @param int $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAccountRequest $request, $user)
    {
        try {
            $account = $this->accountService->createAccount($request->validated(),$user);

            return $this->successWithDataResponse($account);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Update the specified account in storage.
     *
     * @param UpdateAccountRequest $request
     * @param int $user
     * @param int $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request, $user, $account)
    {
        try {
            $accountModel = $this->accountService->getAccountById($account);

            $this->accountService->verifyAccountOwnership($accountModel, $user);

            $accountModel = $this->accountService->updateAccount($account, $request->validated());
            return $this->successWithDataResponse($accountModel);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified account from storage (soft delete).
     *
     * @param int $user
     * @param int $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($user, $account)
    {
        try {
            $accountModel = $this->accountService->getAccountById($account);

            $this->accountService->verifyAccountOwnership($accountModel, $user);

            $this->accountService->deleteAccount($account);
            return $this->successResponse('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}


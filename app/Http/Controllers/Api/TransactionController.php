<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransferRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\AccountService;
use App\Traits\ResponseTrait;

class TransactionController extends Controller
{
    use ResponseTrait;

    /**
     * The transaction service instance.
     *
     * @var TransactionService
     */
    protected TransactionService $transactionService;

    /**
     * The user service instance.
     *
     * @var UserService
     */
    protected UserService $userService;

    /**
     * The account service instance.
     *
     * @var AccountService
     */
    protected AccountService $accountService;

    /**
     * Create a new controller instance.
     *
     * @param TransactionService $transactionService
     * @param UserService $userService
     * @param AccountService $accountService
     */
    public function __construct(
        TransactionService $transactionService,
        UserService $userService,
        AccountService $accountService
    ) {
        $this->transactionService = $transactionService;
        $this->userService = $userService;
        $this->accountService = $accountService;
    }

    /**
     * Transfer money from one account to another.
     *
     * @param TransferRequest $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(TransferRequest $request, $userId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $transaction = $this->transactionService->transferMoney($request->validated(), $userId);

            return $this->successWithDataResponse(new TransactionResource($transaction));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Get transaction history for a user.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTransactions($userId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $transactions = $this->transactionService->getUserTransactions($userId);

            return $this->successWithDataResponse(TransactionResource::collection($transactions));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Get transaction history where account was sender.
     *
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountTransactionsAsSender($userId, $accountId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $account = $this->accountService->getAccountById($accountId);
            $this->accountService->verifyAccountOwnership($account, $userId);

            $transactions = $this->transactionService->getAccountTransactionsAsSender($accountId);

            return $this->successWithDataResponse(TransactionResource::collection($transactions));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    /**
     * Get transaction history where account was receiver.
     *
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountTransactionsAsReceiver($userId, $accountId)
    {
        try {
            $this->userService->verifyUserExists($userId);

            $account = $this->accountService->getAccountById($accountId);
            $this->accountService->verifyAccountOwnership($account, $userId);

            $transactions = $this->transactionService->getAccountTransactionsAsReceiver($accountId);

            return $this->successWithDataResponse(TransactionResource::collection($transactions));
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }
}


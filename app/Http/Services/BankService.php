<?php

namespace App\Http\Services;

use App\Models\Bank;
use App\Http\Resources\V1\BankResource;
use App\Http\Helpers\Http;

use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\responseFail;

class BankService
{
    public function getAllBanks()
    {
        try {
            $banks = Bank::active()->orderBy('name_ar', 'asc')->get();

            return responseSuccess(
                message: __('messages.Banks retrieved successfully'),
                data: BankResource::collection($banks)
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve banks'),
                data: $e->getMessage()
            );
        }
    }
}

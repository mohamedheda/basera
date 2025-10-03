<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\BankService;

class BankController extends Controller
{
    public function __construct(private readonly BankService $bankService) {}

    public function index()
    {
        return $this->bankService->getAllBanks();
    }
}

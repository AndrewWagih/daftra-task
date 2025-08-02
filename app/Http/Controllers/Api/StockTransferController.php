<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockTransferRequest;
use App\Services\StockTransferService;
use Illuminate\Http\JsonResponse;

class StockTransferController extends Controller
{
    public function __construct(private StockTransferService $service) {}

    public function store(StockTransferRequest $request): JsonResponse
    {
        $this->service->transfer($request->validated());

        return response()->json(['message' => 'Stock transferred successfully'], 201);
    }
}
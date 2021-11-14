<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderResource;
use App\Services\Contracts\OrderServiceInterface;

class OrderController extends Controller
{
    /**
     * @var OrderServiceInterface
     */
    private $order_service;

    public function __construct(OrderServiceInterface $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index()
    {
        $resources = $this->order_service->getByUserId(auth()->user()->id);

        return OrderResource::collection($resources);
    }

    public function show($id)
    {
        $result = $this->order_service->getById($id);

        if ($result->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return new OrderResource($result);
    }

    public function create(OrderCreateRequest $request)
    {
        $result = $this->order_service->create($request->event_id, auth()->user()->id, $request->qty);

        return response()->json([
            'message' => 'Order telah dibuat!',
            'data' => new OrderResource($result)
        ], 201);
    }

    public function confirm($id)
    {
        $result = $this->order_service->confirm($id);

        return response()->json([
            'message' => 'Order telah dibayar!',
            'data' => new OrderResource($result)
        ], 200);
    }

    public function cancel($id)
    {
        $result = $this->order_service->cancel($id);

        return response()->json([
            'message' => 'Order telah dibatalkan!',
            'data' => new OrderResource($result)
        ], 200);
    }
}

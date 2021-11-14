<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\Contracts\TicketServiceInterface;

class TicketController extends Controller
{
    /**
     * @var OrderServiceInterface
     */
    private $order_service;

    /**
     * @var TicketServiceInterface
     */
    private $ticket_service;

    public function __construct(OrderServiceInterface $order_service, TicketServiceInterface $ticket_service)
    {
        $this->order_service = $order_service;
        $this->ticket_service = $ticket_service;
    }

    public function index()
    {
        $resources = $this->ticket_service->getByUserId(auth()->user()->id);

        return TicketResource::collection($resources);
    }

    public function getByOrderId($id)
    {
        $order = $this->order_service->getById($id);

        if ($order->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $resources = $this->ticket_service->getByOrderId($id);

        return TicketResource::collection($resources);
    }

    public function show($id)
    {
        $result = $this->ticket_service->find($id);
        if ($result->order->user_id != auth()->user()->id) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return new TicketResource($result);
    }

    public function use($id)
    {
        $result = $this->ticket_service->use($id, auth()->user()->id);

        return response()->json([
            'message' => 'Tiket telah terpakai!',
            'data' => new TicketResource($result)
        ], 200);
    }
}

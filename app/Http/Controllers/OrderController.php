<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',

            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = new Order();
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->save();

        foreach ($request->items as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->food_id = $item['food_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
        }

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order->load('items.food')
        ], 201);
    }

    
   public function getOrder($id)
{
    
    $order = Order::with('items')->find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

   
    $orderDetails = [
        'customer' => [
            'name' => $order->name,
            'email' => $order->email,
            'phone' => $order->phone,
        ],
        'items' => $order->items->map(function($item) {
            return [
                'food_id' => $item->food_id,
                'quantity' => $item->quantity,
            ];
        }),
    ];

    return response()->json($orderDetails);
}

}

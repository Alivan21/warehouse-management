<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Base\SuperOrderController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends SuperOrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('products')->paginate(15);
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('order.form', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrderData($request);

        DB::transaction(function () use ($validatedData, $request) {
            $order = Order::create([
                'customer_name' => $validatedData['customer_name'],
                'order_date' => $validatedData['order_date'],
            ]);

            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                $price = $product->price; // Or use a specific price for the order item
                $order->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity'],
                    'price' => $price
                ]);
                $totalAmount += $price * $item['quantity'];
                // Optionally, update product stock here if not handled by a dedicated inventory system
                // $product->decrement('quantity', $item['quantity']);
            }
            $order->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('products');
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        $order->load('products'); // Load existing items for the form
        return view('order.form', compact('order', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validatedData = $this->validateOrderData($request);

        DB::transaction(function () use ($validatedData, $request, $order) {
            $order->update([
                'customer_name' => $validatedData['customer_name'],
                'order_date' => $validatedData['order_date'],
            ]);

            // Detach existing products and re-attach new/updated ones
            $order->products()->detach();
            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {
                $product = Product::find($item['product_id']);
                $price = $product->price; // Or use a specific price for the order item
                $order->products()->attach($item['product_id'], [
                    'quantity' => $item['quantity'],
                    'price' => $price
                ]);
                $totalAmount += $price * $item['quantity'];
            }
            $order->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->products()->detach();
            $order->delete();
        });
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}

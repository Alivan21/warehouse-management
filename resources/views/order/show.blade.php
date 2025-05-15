<!-- resources/views/order/show.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Order Details #{{ $order->id }}</h1>

    <table class="table-bordered mb-4 table">
      <tr>
        <th>Customer Name</th>
        <td>{{ $order->customer_name }}</td>
      </tr>
      <tr>
        <th>Order Date</th>
        <td>{{ $order->order_date }}</td>
      </tr>
      <tr>
        <th>Total Amount</th>
        <td>{{ number_format($order->total_amount, 2) }}</td>
      </tr>
      <tr>
        <th>Created At</th>
        <td>{{ $order->created_at }}</td>
      </tr>
      <tr>
        <th>Updated At</th>
        <td>{{ $order->updated_at }}</td>
      </tr>
    </table>

    <h2>Order Items</h2>
    @if ($order->products->isNotEmpty())
      <table class="table-striped table">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>SKU</th>
            <th>Quantity</th>
            <th>Price per Item</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($order->products as $product)
            <tr>
              <td>{{ $product->name }}</td>
              <td>{{ $product->sku }}</td>
              <td>{{ $product->pivot->quantity }}</td>
              <td>{{ number_format($product->pivot->price, 2) }}</td>
              <td>{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p>No items in this order.</p>
    @endif

    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to List</a>
  </div>
@endsection

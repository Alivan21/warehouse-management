<!-- resources/views/order/index.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Order List</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create New Order</a>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer Name</th>
          <th>Order Date</th>
          <th>Total Amount</th>
          <th>No. of Items</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->order_date }}</td>
            <td>{{ number_format($order->total_amount, 2) }}</td>
            <td>{{ $order->products->count() }}</td>
            <td>
              <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
              <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                  onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">No orders found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{ $orders->links() }} <!-- Pagination -->
  </div>
@endsection

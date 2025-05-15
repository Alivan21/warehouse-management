<!-- resources/views/inventory/show.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Inventory Item Details</h1>

    <table class="table-bordered table">
      <tr>
        <th>ID</th>
        <td>{{ $inventory->id }}</td>
      </tr>
      <tr>
        <th>Product</th>
        <td>{{ $inventory->product->name ?? 'N/A' }} (ID: {{ $inventory->product_id }})</td>
      </tr>
      <tr>
        <th>Quantity</th>
        <td>{{ $inventory->quantity }}</td>
      </tr>
      <tr>
        <th>Location</th>
        <td>{{ $inventory->location ?? 'N/A' }}</td>
      </tr>
      <tr>
        <th>Created At</th>
        <td>{{ $inventory->created_at }}</td>
      </tr>
      <tr>
        <th>Updated At</th>
        <td>{{ $inventory->updated_at }}</td>
      </tr>
    </table>

    <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back to List</a>
  </div>
@endsection

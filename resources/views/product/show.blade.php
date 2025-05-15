<!-- resources/views/product/show.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Product Details</h1>

    <table class="table-bordered table">
      <tr>
        <th>ID</th>
        <td>{{ $product->id }}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td>{{ $product->name }}</td>
      </tr>
      <tr>
        <th>SKU</th>
        <td>{{ $product->sku }}</td>
      </tr>
      <tr>
        <th>Description</th>
        <td>{{ $product->description ?? 'N/A' }}</td>
      </tr>
      <tr>
        <th>Price</th>
        <td>{{ $product->price }}</td>
      </tr>
      <tr>
        <th>Quantity</th>
        <td>{{ $product->quantity }}</td>
      </tr>
      <tr>
        <th>Supplier</th>
        <td>{{ $product->supplier->name ?? 'N/A' }} (ID: {{ $product->supplier_id }})</td>
      </tr>
      <tr>
        <th>Created At</th>
        <td>{{ $product->created_at }}</td>
      </tr>
      <tr>
        <th>Updated At</th>
        <td>{{ $product->updated_at }}</td>
      </tr>
    </table>

    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
  </div>
@endsection

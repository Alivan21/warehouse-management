<!-- resources/views/inventory/index.blade.php -->
@extends('layouts.app') <!-- Assuming you have a layout file -->

@section('content')
  <div class="container">
    <h1>Inventory List</h1>
    <a href="{{ route('inventories.create') }}" class="btn btn-primary mb-3">Add New Inventory Item</a>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Location</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($inventories as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->product->name ?? 'N/A' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->location }}</td>
            <td>
              <a href="{{ route('inventories.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
              <a href="{{ route('inventories.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('inventories.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                  onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">No inventory items found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{ $inventories->links() }} <!-- Pagination -->
  </div>
@endsection

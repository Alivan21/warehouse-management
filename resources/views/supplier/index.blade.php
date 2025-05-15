<!-- resources/views/supplier/index.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Supplier List</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Add New Supplier</a>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Contact Info</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($suppliers as $supplier)
          <tr>
            <td>{{ $supplier->id }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->contact_info }}</td>
            <td>
              <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info btn-sm">View</a>
              <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                  onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4">No suppliers found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{ $suppliers->links() }} <!-- Pagination -->
  </div>
@endsection

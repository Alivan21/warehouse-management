<!-- resources/views/inventory/form.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ isset($inventory) ? 'Edit' : 'Add' }} Inventory Item</h1>

    <form action="{{ isset($inventory) ? route('inventories.update', $inventory->id) : route('inventories.store') }}"
      method="POST">
      @csrf
      @if (isset($inventory))
        @method('PUT')
      @endif

      <div class="form-group mb-3">
        <label for="product_id">Product</label>
        <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
          <option value="">Select Product</option>
          @foreach ($products as $product)
            <option value="{{ $product->id }}"
              {{ (isset($inventory) && $inventory->product_id == $product->id) || old('product_id') == $product->id ? 'selected' : '' }}>
              {{ $product->name }} (SKU: {{ $product->sku }})
            </option>
          @endforeach
        </select>
        @error('product_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
          value="{{ old('quantity', $inventory->quantity ?? '') }}" required min="0">
        @error('quantity')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="location">Location</label>
        <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror"
          value="{{ old('location', $inventory->location ?? '') }}">
        @error('location')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">{{ isset($inventory) ? 'Update' : 'Save' }}</button>
      <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
@endsection

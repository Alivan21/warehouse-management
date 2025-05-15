<!-- resources/views/product/form.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ isset($product) ? 'Edit' : 'Add' }} Product</h1>

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST">
      @csrf
      @if (isset($product))
        @method('PUT')
      @endif

      <div class="form-group mb-3">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
          value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="sku">SKU</label>
        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
          value="{{ old('sku', $product->sku ?? '') }}" required>
        @error('sku')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="price">Price</label>
        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
          value="{{ old('price', $product->price ?? '') }}" required min="0" step="0.01">
        @error('price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="quantity">Quantity (Initial Stock)</label>
        <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
          value="{{ old('quantity', $product->quantity ?? '') }}" required min="0">
        @error('quantity')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="supplier_id">Supplier</label>
        <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror"
          required>
          <option value="">Select Supplier</option>
          @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}"
              {{ (isset($product) && $product->supplier_id == $supplier->id) || old('supplier_id') == $supplier->id ? 'selected' : '' }}>
              {{ $supplier->name }}
            </option>
          @endforeach
        </select>
        @error('supplier_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Save' }}</button>
      <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
@endsection

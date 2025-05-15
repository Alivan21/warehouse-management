<!-- resources/views/order/form.blade.php -->
@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>{{ isset($order) ? 'Edit' : 'Create' }} Order</h1>

    <form action="{{ isset($order) ? route('orders.update', $order->id) : route('orders.store') }}" method="POST">
      @csrf
      @if (isset($order))
        @method('PUT')
      @endif

      <div class="form-group mb-3">
        <label for="customer_name">Customer Name</label>
        <input type="text" name="customer_name" id="customer_name"
          class="form-control @error('customer_name') is-invalid @enderror"
          value="{{ old('customer_name', $order->customer_name ?? '') }}" required>
        @error('customer_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-group mb-3">
        <label for="order_date">Order Date</label>
        <input type="date" name="order_date" id="order_date"
          class="form-control @error('order_date') is-invalid @enderror"
          value="{{ old('order_date', $order->order_date ?? date('Y-m-d')) }}" required>
        @error('order_date')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <hr>
      <h3>Order Items</h3>
      <div id="order-items-container">
        @php
          $items = old(
              'items',
              isset($order)
                  ? $order->products
                      ->map(function ($product) {
                          return [
                              'product_id' => $product->id,
                              'quantity' => $product->pivot->quantity,
                              // 'price' => $product->pivot->price // Not needed for form submission directly, price taken from product master
                          ];
                      })
                      ->toArray()
                  : [['product_id' => '', 'quantity' => 1]],
          );
        @endphp

        @foreach ($items as $index => $item)
          <div class="row order-item mb-2">
            <div class="col-md-6">
              <label for="items[{{ $index }}][product_id]">Product</label>
              <select name="items[{{ $index }}][product_id]"
                class="form-control product-select @error('items.' . $index . '.product_id') is-invalid @enderror"
                required>
                <option value="">Select Product</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}" {{ ($item['product_id'] ?? '') == $product->id ? 'selected' : '' }}
                    data-price="{{ $product->price }}">
                    {{ $product->name }} (SKU: {{ $product->sku }}) - Price: {{ $product->price }}
                  </option>
                @endforeach
              </select>
              @error('items.' . $index . '.product_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-4">
              <label for="items[{{ $index }}][quantity]">Quantity</label>
              <input type="number" name="items[{{ $index }}][quantity]"
                class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror"
                value="{{ $item['quantity'] ?? 1 }}" required min="1">
              @error('items.' . $index . '.quantity')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-2 d-flex align-items-end">
              @if ($index > 0)
                <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
              @endif
            </div>
          </div>
        @endforeach
      </div>
      <button type="button" id="add-item-btn" class="btn btn-success mb-3">Add Another Item</button>

      <hr>
      <button type="submit" class="btn btn-primary">{{ isset($order) ? 'Update' : 'Save' }} Order</button>
      <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = {{ count($items) }};
        const container = document.getElementById('order-items-container');
        const addItemButton = document.getElementById('add-item-btn');

        addItemButton.addEventListener('click', function() {
          const newItemRow = document.createElement('div');
          newItemRow.classList.add('row', 'order-item', 'mb-2');
          newItemRow.innerHTML = `
                <div class="col-md-6">
                    <label for="items[${itemIndex}][product_id]">Product</label>
                    <select name="items[${itemIndex}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (SKU: {{ $product->sku }}) - Price: {{ $product->price }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="items[${itemIndex}][quantity]">Quantity</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity" value="1" required min="1">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-item-btn">Remove</button>
                </div>
            `;
          container.appendChild(newItemRow);
          itemIndex++;
        });

        container.addEventListener('click', function(event) {
          if (event.target.classList.contains('remove-item-btn')) {
            event.target.closest('.order-item').remove();
          }
        });
      });
    </script>
  @endpush
@endsection

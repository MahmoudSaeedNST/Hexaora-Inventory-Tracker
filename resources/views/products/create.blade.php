<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 mt-6">
        <h1 class="text-2xl font-bold mb-6">Add Product</h1>

        <form method="POST" action="{{ route('products.store') }}" class="bg-white shadow rounded-lg p-6 space-y-5">
            @csrf

            <div>
                <label class="block mb-1 text-sm font-medium">Product Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border-gray-300 rounded px-3 py-2">
                @error('name')
                <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">SKU</label>
                <input type="text" name="sku" value="{{ old('sku') }}"
                    class="w-full border-gray-300 rounded px-3 py-2">
                @error('sku') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Stock Quantity</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                    class="w-full border-gray-300 rounded px-3 py-2">
                @error('stock_quantity') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium">Reorder Level</label>
                <input type="number" name="reorder_level" value="{{ old('reorder_level', 5) }}"
                    class="w-full border-gray-300 rounded px-3 py-2">
                @error('reorder_level') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
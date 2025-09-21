<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Products</h1>
            <div class="flex gap-2">
                <a href="{{ route('products.create') }}" 
                   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Add Product
                </a>
                <a href="{{ route('notifications') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Notifications
                </a>
            </div>
        </div>

        <form method="GET" class="flex gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or SKU..."
                   class="border border-gray-300 rounded px-3 py-2 w-72">
            <select name="low_stock" class="border border-gray-300 rounded px-3 py-2">
                <option value="">All Products</option>
                <option value="1" @selected(request('low_stock'))>Low Stock Only</option>
            </select>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Search
            </button>
        </form>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">SKU</th>
                        <th class="px-6 py-3">Stock</th>
                        <th class="px-6 py-3">Reorder Level</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="border-b {{ $product->isLowStock() ? 'bg-red-50' : 'bg-white' }}">
                        <td class="px-6 py-3">{{ $product->name }}</td>
                        <td class="px-6 py-3">{{ $product->sku }}</td>
                        <td class="px-6 py-3 font-semibold {{ $product->isLowStock() ? 'text-red-600' : '' }}">
                            {{ $product->stock_quantity }}
                        </td>
                        <td class="px-6 py-3">{{ $product->reorder_level }}</td>
                        <td class="px-6 py-3 text-right space-x-3">
                            <a href="{{ route('products.edit', $product) }}" 
                               class="text-blue-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this product?')" 
                                        class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</x-app-layout>
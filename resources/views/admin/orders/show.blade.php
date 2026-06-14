@extends('admin.layouts.app')

@section('title', 'Order Details #' . $order->id)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Order Info -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 dark:border-gray-700">Order Items</h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Product</th>
                            <th class="py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Price</th>
                            <th class="py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Quantity</th>
                            <th class="py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->product->name ?? 'Unknown Product' }}
                                </td>
                                <td class="py-3 text-sm text-center text-gray-900 dark:text-gray-100">${{ number_format($item->price, 2) }}</td>
                                <td class="py-3 text-sm text-center text-gray-900 dark:text-gray-100">{{ $item->quantity }}</td>
                                <td class="py-3 text-sm text-right text-gray-900 dark:text-gray-100">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="py-3 text-right font-bold">Total Amount:</td>
                            <td class="py-3 text-right font-bold text-lg">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 dark:border-gray-700">Shipping Address</h3>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Sidebar / Status Update -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 dark:border-gray-700">Customer Info</h3>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 dark:border-gray-700">Update Status</h3>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

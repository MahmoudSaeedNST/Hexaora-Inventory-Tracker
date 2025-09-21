<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Notifications</h1>

        <div class="bg-white shadow rounded-lg divide-y">
            @forelse($notifications as $notification)
                <div class="p-4 {{ $loop->odd ? 'bg-gray-50' : '' }}">
                    <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <div class="p-4 text-gray-500">No notifications yet.</div>
            @endforelse
        </div>

        <div class="mt-6">{{ $notifications->links() }}</div>
    </div>
</x-app-layout>
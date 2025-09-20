<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white shadow rounded-lg mt-6 p-6">
        <h1 class="text-xl font-bold mb-4">Notifications</h1>
        <ul class="divide-y">
            @forelse($notifications as $notification)
                <li class="py-3 {{ $loop->odd ? 'bg-gray-50' : '' }}">
                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                    <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="py-3 text-gray-500">No notifications yet.</li>
            @endforelse
        </ul>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
</x-app-layout>

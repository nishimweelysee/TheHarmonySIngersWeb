@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Notifications</h2>
                    <div class="flex space-x-2">
                        <button id="mark-all-read"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Mark All as Read
                        </button>
                    </div>
                </div>

                @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                    <div
                        class="border rounded-lg p-4 {{ $notification->status === 'unread' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3
                                    class="text-lg font-semibold text-gray-900 {{ $notification->status === 'unread' ? 'text-blue-900' : 'text-gray-700' }}">
                                    {{ $notification->title }}
                                </h3>
                                <p class="text-gray-600 mt-2 whitespace-pre-line">{{ $notification->message }}</p>
                                <div class="flex items-center mt-3 text-sm text-gray-500">
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->status === 'unread')
                                    <span
                                        class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Unread
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                @if($notification->status === 'unread')
                                <button onclick="markAsRead({{ $notification->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Mark as Read
                                </button>
                                @endif
                                <button onclick="deleteNotification({{ $notification->id }})"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

document.getElementById('mark-all-read').addEventListener('click', function() {
    fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
});
</script>
@endsection
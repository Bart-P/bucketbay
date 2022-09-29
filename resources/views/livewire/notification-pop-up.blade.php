@if(session()->has('notificationMessage'))
    <div class="notificationWrapper alert alert-{{ $notificationType }}"
         x-data="{ shown: @entangle('show') }"
         x-show="shown ? setTimeout(() => $wire.hideNotification(), 5000) : shown">
        {{ session('notificationMessage')['message'] }}
    </div>
@endif
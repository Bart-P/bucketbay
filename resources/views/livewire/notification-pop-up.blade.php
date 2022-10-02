<div class="notificationWrapper alert"
     x-data="{ shown: @entangle('show'), type: @entangle('notificationType') }"
     :class="type"
     x-show="shown ? setTimeout(() => $wire.hideNotification(), 5000) : shown">
    {{ $notificationMsg }}
</div>
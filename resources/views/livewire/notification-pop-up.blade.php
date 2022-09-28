<div class="notificationWrapper">
    @foreach($notificationMessages as $key => $msg)
        <div class="notificationBox alert alert-success" x-data="{'show': @entangle('showNotification')}"
             x-show="show, setTimeout(() => show = false, 5000)"
             x-transition>
            <i class="bi-check2-circle"></i> {{$msg['text']}}
        </div>
    @endforeach

    {{--
        <div class="notificationBox alert alert-danger">
            <i class="bi-exclamation-triangle"></i> Es hat nicht geklappt, fehler ist so und so und so und so!
        </div>

        <div class="notificationBox alert alert-primary">
            <i class="bi-info-circle"></i> Es hat nicht geklappt, fehler ist so und so und so und so!
        </div>
    --}}

</div>
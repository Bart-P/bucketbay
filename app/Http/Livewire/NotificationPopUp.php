<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationPopUp extends Component
{
    public $listeners = ['notifySuccess', 'hideNotification'];
    public $show = false;
    public $notificationType;

    public function render(): Factory|View|Application
    {
        // TODO class is not shown properly.. figure out why it is only shown after reload of page, first page load bg of popup stays white
        if (session()->has('notificationMessage') && !empty(session('notificationMessage')['message']) && !empty(session('notificationMessage')['type'])) {
            $this->show = true;
        } else {
            session()->put('notificationMessage', ['message' => '', 'type' => '']);
        }
        return view('livewire.notification-pop-up');
    }

    public function notifySuccess()
    {
        if (session()->has('notificationMessage')) {
            $this->notificationType = 'success';
            $this->show = true;
            $this->render();
        }
    }

    public function hideNotification()
    {
        $this->show = false;
        session()->forget('notificationMessage');
    }
}
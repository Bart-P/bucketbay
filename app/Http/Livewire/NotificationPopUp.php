<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationPopUp extends Component
{
    public $listeners = ['notifySuccess', 'notifyFailed', 'hideNotification'];
    public $notifyUser = false;
    public $notificationMsg;
    public $notificationType;

    public function render(): Factory|View|Application
    {
        return view('livewire.notification-pop-up');
    }

    public function notifySuccess(string $msg)
    {
        $this->notificationType = 'alert-success';
        $this->notificationMsg = $msg;
        $this->notifyUser = true;
        $this->render();
    }

    public function notifyFailed(string $msg)
    {
        $this->notificationType = 'alert-warning';
        $this->notificationMsg = $msg;
        $this->notifyUser = true;
        $this->render();
    }

    public function hideNotification()
    {
        $this->notifyUser = false;
    }
}
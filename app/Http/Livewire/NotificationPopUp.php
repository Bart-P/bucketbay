<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationPopUp extends Component
{
    public $listeners = ['notifyUser'];
    public $showNotification = false;
    public $notificationMessages = [];

    public function boot()
    {
        $this->notificationMessages = session()->has('notificationMessages') ? session('notificationMessages') : [];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.notification-pop-up');
    }

    public function notifyUser()
    {
        $this->showNotification = true;
        $this->render();
    }
}
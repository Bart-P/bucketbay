<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case OPEN = '1 open';
    case INPROGRESS = '2 in_progress';
    case SENT = '3 sent';
    case INVOICED = '4 invoiced';
    case CLOSED = '5 closed';
    case CANCELLED = '6 cancelled';
}
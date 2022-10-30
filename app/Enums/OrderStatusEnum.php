<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case OPEN = 'open';
    case INPROGRESS = 'in_progress';
    case SENT = 'sent';
    case INVOICED = 'invoiced';
    case PAID = 'paid';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';
}
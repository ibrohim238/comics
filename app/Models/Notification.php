<?php

namespace App\Models;

use App\Versions\V1\Traits\GroupedLastScope;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use GroupedLastScope;
}

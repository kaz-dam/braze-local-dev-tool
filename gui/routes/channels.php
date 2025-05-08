<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('file.watcher', function ($user) {
    return true;
});

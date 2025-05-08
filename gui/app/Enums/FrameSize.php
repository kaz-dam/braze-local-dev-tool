<?php

namespace App\Enums;

enum FrameSize: int
{
    case MOBILE = 450;
    case TABLET = 768;
    case DESKTOP = 1024;
    case DESKTOP_LARGE = 1440;
}

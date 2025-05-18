<?php

namespace App\Services;

use Liquid\Template;

class LiquidCompilingService
{
    public function __construct(protected Template $template)
    {}

    public function compile(string $filePath)
    {
        $template->parse($filePath);
        $template->render();
    }
}

<?php

namespace App\Services;

use Liquid\Template;
use App\Support\Liquid\ContentBlockResolver;

class LiquidService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function renderTemplate(string $templateContent)
    {
        $firstLevelBlocksResolved = ContentBlockResolver::apply($templateContent);
        $secondLevelBlocksResolved = ContentBlockResolver::apply($firstLevelBlocksResolved);

        $template = new Template();

        $template->parse($secondLevelBlocksResolved);
        return $template->render();
    }

    public function parseContentBlocks()
    {

    }
}

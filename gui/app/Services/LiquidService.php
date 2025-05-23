<?php

namespace App\Services;

use Liquid\Template;
use App\Support\Liquid\ContentBlockResolver;
use App\Support\Liquid\CustomAttributeResolver;

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

        $customAttributesResolved = CustomAttributeResolver::apply($secondLevelBlocksResolved);

        $template = new Template();

        $template->parse($customAttributesResolved);
        return $template->render();
    }

    public function parseContentBlocks()
    {

    }
}

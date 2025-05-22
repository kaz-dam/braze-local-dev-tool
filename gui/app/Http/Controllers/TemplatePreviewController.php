<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileHandlingService;

class TemplatePreviewController extends Controller
{
    public function __construct(
        protected FileHandlingService $fileHandlingService
    ) {}

    public function get(Request $request, string $fileName)
    {
        $renderedTemplate = $this->fileHandlingService->getCompiledFileContent($fileName);

        return response($renderedTemplate)
            ->header('Content-Type', 'text/html')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}

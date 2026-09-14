<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WebPageParserService;
use Illuminate\Http\JsonResponse;

class ParserController extends Controller
{
    public function __construct(protected WebPageParserService $parser) {}

    public function parse(): JsonResponse
    {
        return response()->json([
            'data' => $this->parser->readHtml(),
        ]);
    }
}

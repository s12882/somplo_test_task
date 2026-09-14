<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WebPageParserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    public function __construct(protected WebPageParserService $parser) {}

    public function parse(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->parser->readHtml($request->boolean('force')),
        ]);
    }
}

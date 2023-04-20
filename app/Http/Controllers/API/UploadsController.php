<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $path = $request->file('file')->store('public/product-images');

        return \response()->json([
            'path' => str_replace('public', 'storage', $path)
        ]);
    }
}

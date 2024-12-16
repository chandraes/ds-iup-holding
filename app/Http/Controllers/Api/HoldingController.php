<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HoldingController extends Controller
{
    public function checkConnection(Request $request)
    {
        return response()->json([
            'code' => 200,
            'message' => 'Connected to Holding API'
        ], 200);
    }
}

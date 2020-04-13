<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class VerificationCodeController extends Controller
{
    public function store() {
        return response()->json(['test_message' => 'store verification code']);
    }
}

<?php

namespace Fedn\Http\Controllers\Api;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Quota;
class QuotaController extends Controller
{
    public function list() {
        $quotas = Quota::orderBy('id', 'desc')->paginate(20);
        return response()->json($quotas);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotAIController extends Controller
{
    public function chat(Request $request)
    {
        return view('components.chat-widget');
    }
}

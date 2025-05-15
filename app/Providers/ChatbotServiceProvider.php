<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use HalilCosdu\ChatBot\ChatBot;

class ChatbotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Tidak perlu me-register 'chatbot' karena sudah diregistrasi oleh
        // HalilCosdu\ChatBot\ChatBotServiceProvider
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */

     public function boot()
     {
        //  $this->app->make('chatbot')->configure([
        //      'assistant_id' => env('OPENAI_ASSISTANT_ID'),
        //      'api_key' => env('OPENAI_API_KEY'),
        //      'organization' => env('OPENAI_ORGANIZATION'),
        //  ]);
     }

}

<?php

use HalilCosdu\ChatBot\Models\Thread;
use HalilCosdu\ChatBot\Models\ThreadMessage;

// config for HalilCosdu/ChatBot

return [
    'assistant_id' => env('OPENAI_ASSISTANT_ID'),
    'api_key' => env('OPENAI_API_KEY'),
    'organization' => env('OPENAI_ORGANIZATION'),
    'request_timeout' => env('OPENAI_TIMEOUT', 300),
    'sleep_seconds' => env('OPENAI_SLEEP_SECONDS', 1),
    'models' => [
        'thread' => env('CHATBOT_THREAD_MODEL', \HalilCosdu\ChatBot\Models\Thread::class),
        'thread_messages' => env('CHATBOT_THREAD_MESSAGE_MODEL', \HalilCosdu\ChatBot\Models\ThreadMessage::class),
    ],
];
// import OpenAI from "openai";

// const openai = new OpenAI({
//   apiKey: "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",
// });

// const completion = openai.chat.completions.create({
//   model: "gpt-4o-mini",
//   store: true,
//   messages: [
//     {"role": "user", "content": "write a haiku about ai"},
//   ],
// });

// completion.then((result) => console.log(result.choices[0].message));

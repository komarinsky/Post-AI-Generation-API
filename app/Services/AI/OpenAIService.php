<?php

namespace App\Services\AI;

use OpenAI;
use OpenAI\Client;

class OpenAIService
{
    private Client $client;

    public function __construct()
    {
        $this->client = OpenAI::client(config('open_ai.api_key'));
    }

    protected function prompt(string $content): string
    {
        $result = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'max_tokens' => 512,
            'temperature' => 0.8,
            'frequency_penalty' => -0.1,
            'presence_penalty' => -0.1,
            'messages' => [
                ['role' => 'user', 'content' => $content],
            ],
        ]);

        return $result->choices[0]->message->content;
    }
}

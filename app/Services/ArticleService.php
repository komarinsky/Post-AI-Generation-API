<?php

namespace App\Services;

use App\Services\AI\OpenAIClass;

final class ArticleService extends OpenAIClass
{
    public function generateArticle(string $title): string
    {
        return $this->prompt(
            $this->generateContentForAIPrompt($title)
        );
    }

    private function generateContentForAIPrompt(string $title): string
    {
        return "Generate an article or post on the designated topic with the title \"$title\".
            Provide a minimum of 3 sentences and a maximum of 16 sentences.
            Avoid seeking additional clarification; simply proceed to compose the article.";
    }
}

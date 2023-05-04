<?php

function estimateTokens($text) {
    $words = str_word_count($text);
    // A rough estimation of tokens per word can be derived from the given example: 1000 tokens = 750 words.
    $tokens_per_word = 1000 / 750;
    
    // Estimate the number of tokens by multiplying the number of words by tokens per word.
    $estimated_tokens = $words * $tokens_per_word;
    
    // Round the result to the nearest whole number.
    $estimated_tokens = round($estimated_tokens);
    
    return $estimated_tokens;
}

$text = "Multiple models, each with different capabilities and price points. Prices are per 1,000 tokens. You can think of tokens as pieces of words, where 1,000 tokens is about 750 words. This paragraph is 35 tokens.";
$estimated_token_count = estimateTokens($text);
echo "Estimated token count: $estimated_token_count\n";
?>

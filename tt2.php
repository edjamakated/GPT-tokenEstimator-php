<?php

function countTokens($text) {
    $python_script = 'token_counter.py';
    $escaped_text = escapeshellarg($text);
    $token_count = shell_exec("python3 $python_script $escaped_text");
    return intval($token_count);
}

$prompt = "Many words map to one token, but some don't: indivisible. Unicode characters like emojis may be split into many tokens containing the underlying bytes: 🤚🏾 Sequences of characters commonly found next to each other may be grouped together: 1234567890";

$token_count = countTokens($prompt);
echo "Token count: $token_count\n";
?>

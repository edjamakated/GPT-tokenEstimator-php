<?php

function countTokens($text) {
    preg_match_all("#'s|'t|'re|'ve|'m|'ll|'d| ?\p{L}+| ?\p{N}+| ?[^\s\p{L}\p{N}]+|\s+(?!\S)|\s+#u", $text, $matches);
    if (!isset($matches[0]) || count($matches[0]) == 0) {
        return 0;
    }
    return count($matches[0]);
}

$prompt = "Many words map to one token, but some don't: indivisible. Unicode characters like emojis may be split into many tokens containing the underlying bytes: 🤚🏾 Sequences of characters commonly found next to each other may be grouped together: 1234567890";
$token_count = countTokens($prompt);
echo "Token count: $token_count\n";
?>

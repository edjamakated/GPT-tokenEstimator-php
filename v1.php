<?php

function gpt_unichr($c) {
    if (ord($c[0]) >= 0 && ord($c[0]) <= 127) {
        return ord($c[0]);
    }
    if (ord($c[0]) >= 192 && ord($c[0]) <= 223) {
        return (ord($c[0]) - 192) * 64 + (ord($c[1]) - 128);
    }
    if (ord($c[0]) >= 224 && ord($c[0]) <= 239) {
        return (ord($c[0]) - 224) * 4096 + (ord($c[1]) - 128) * 64 + (ord($c[2]) - 128);
    }
    if (ord($c[0]) >= 240 && ord($c[0]) <= 247) {
        return (ord($c[0]) - 240) * 262144 + (ord($c[1]) - 128) * 4096 + (ord($c[2]) - 128) * 64 + (ord($c[3]) - 128);
    }
}

function countTokens($text) {
    preg_match_all("#'s|'t|'re|'ve|'m|'ll|'d| ?\p{L}+| ?\p{N}+| ?[^\s\p{L}\p{N}]+|\s+(?!\S)|\s+#u", $text, $matches);

    if (!isset($matches[0]) || count($matches[0]) == 0) {
        return 0;
    }
    
    $token_count = 0;
    foreach($matches[0] as $token) {
        $chars = array();
        $token = gpt_utf8_encode($token);
        if (function_exists('mb_strlen')) {
            $len = mb_strlen($token, 'UTF-8');
            for ($i = 0; $i < $len; $i++) {
                $chars[] = mb_substr($token, $i, 1, 'UTF-8');
            }
        } else {
            $chars = str_split($token);
        }

        $unicode_chars = array_map('gpt_unichr', $chars);
        $token_count += count($unicode_chars);
    }
    return $token_count;
}

$prompt = "Many words map to one token, but some don't: indivisible. Unicode characters like emojis may be split into many tokens containing the underlying bytes: 🤚🏾 Sequences of characters commonly found next to each other may be grouped together: 1234567890";

$token_count = countTokens($prompt);
echo "Token count: $token_count\n";
?>

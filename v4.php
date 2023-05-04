// 4 characters is 1 token
A helpful rule of thumb is that one token generally corresponds to ~4 characters of text for common English text. This translates to roughly ¾ of a word (so 100 tokens ~= 75 words).

What are tokens and how to count them?
Raf avatar
Written by Raf. Updated over a week ago
What are tokens?
Tokens can be thought of as pieces of words. Before the API processes the prompts, the input is broken down into tokens. These tokens are not cut up exactly where the words start or end - tokens can include trailing spaces and even sub-words. Here are some helpful rules of thumb for understanding tokens in terms of lengths:

1 token ~= 4 chars in English

1 token ~= ¾ words

100 tokens ~= 75 words

Or 

1-2 sentence ~= 30 tokens

1 paragraph ~= 100 tokens

1,500 words ~= 2048 tokens

To get additional context on how tokens stack up, consider this:

Wayne Gretzky’s quote "You miss 100% of the shots you don't take" contains 11 tokens.

OpenAI’s charter contains 476 tokens.

The transcript of the US Declaration of Independence contains 1,695 tokens.

How words are split into tokens is also language-dependent. For example ‘Cómo estás’ (‘How are you’ in Spanish) contains 5 tokens (for 10 chars). The higher token-to-char ratio can make it more expensive to implement the API for languages other than English.

 

To further explore tokenization, you can use our interactive Tokenizer tool, which allows you to calculate the number of tokens and see how text is broken into tokens. Alternatively, if you'd like to tokenize text programmatically, use Tiktoken as a fast BPE tokenizer specifically used for OpenAI models. Other such libraries you can explore as well include transformers package for Python or the gpt-3-encoder package for node.js.

 

Token Limits
Depending on the model used, requests can use up to 4097 tokens shared between prompt and completion. If your prompt is 4000 tokens, your completion can be 97 tokens at most. 

 

The limit is currently a technical limitation, but there are often creative ways to solve problems within the limit, e.g. condensing your prompt, breaking the text into smaller pieces, etc.

 

Token Pricing
The API offers multiple model types at different price points. Each model has a spectrum of capabilities, with davinci being the most capable and ada the fastest. Requests to these different models are priced differently. You can find details on token pricing here. 

 

Exploring tokens
The API treats words according to their context in the corpus data. GPT-3 takes the prompt, converts the input into a list of tokens, processes the prompt, and converts the predicted tokens back to the words we see in the response.

What might appear as two identical words to us may be generated into different tokens depending on how they are structured within the text. Consider how the API generates token values for the word ‘red’ based on its context within the text:

 



In the first example above the token “2266” for ‘ red’ includes a trailing space.

 



The token “2296” for ‘ Red’ (with a leading space and starting with a capital letter) is different from the token “2266” for ‘ red’ with a lowercase letter.

 



When ‘Red’ is used in the beginning of a sentence, the generated token does not include a leading space. The token “7738” is different from the previous two examples of the word.

 

Observations:
The more probable/frequent a token is, the lower the token number assigned to it:

The token generated for the period is the same (“13”) in all 3 sentences. This is because, contextually, the period is used pretty similarly throughout the corpus data.

The token generated for ‘red’ varies depending on its placement within the sentence:

Lowercase in the middle of a sentence: ‘ red’ - (token: “2266”)

Uppercase in the middle of a sentence: ‘ Red’ -  (token: “2297”)

Uppercase at the beginning of a sentence: ‘Red’ - (token: “7738”)

Using knowledge of tokens for better prompt design
Prompts that end with a space
Now since we know that tokens can include trailing space characters, it helps to keep in mind that prompts ending with a space character may result in lower-quality output. This is because the API already incorporates trailing spaces in its dictionary of tokens.

 

Using the logit_bias parameter
Biases for specific tokens can be set in the logit_bias parameter to modify the likelihood of the specified tokens appearing in the completion. Consider, for example, that we are building an AI Baking Assistant that is sensitive about its user’s egg allergies. 

When we run the API with the prompt ‘The ingredients for banana bread are”, the response will include ‘eggs’ as the second ingredient with a probability of 26.8%. 
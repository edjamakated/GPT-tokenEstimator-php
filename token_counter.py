import sys
from tiktoken import Tokenizer
from tiktoken.tokenizer import Tokenizer

def count_tokens(text):
    tokenizer = Tokenizer()
    token_count = len(list(tokenizer.tokenize(text)))
    return token_count

if __name__ == "__main__":
    text = sys.argv[1]
    token_count = count_tokens(text)
    print(token_count)

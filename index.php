<?php


function getHangmanState(int $hangmanState = 0): string
{
    $states = [
        "
      +---+
      |   |
          |
          |
          |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
      O   |
          |
          |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
      O   |
      |   |
          |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
      O   |
     /|   |
          |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
      O   |
     /|\  |
          |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
      O   |
     /|\  |
     / \  |
          |
    =========
    " . PHP_EOL,
        "
      +---+
      |   |
     [O]  |
     /|\  |
     / \  |
          |
    =========
    " . PHP_EOL,
    ];

    return $states[$hangmanState];
}

function showMenu(): void
{
    echo "Меню:" . PHP_EOL;
    echo "1. Начать новую игру" . PHP_EOL;
    echo "2. Выход" . PHP_EOL;
}

function showGameStatus(array $usedLetters, array $maskedWord, int $countErrors): void
{
    echo "Статус игры: " . PHP_EOL;
    echo getHangmanState($countErrors);
    echo "Использованные буквы:" . implode(',', $usedLetters) . PHP_EOL;
    echo "Загаданное слово:" . implode('', $maskedWord) . PHP_EOL;
    echo "Количество ошибок:" . $countErrors . PHP_EOL;
    echo PHP_EOL;
}

function showGameResult(array $hiddenWord, int $countAttempts, int $countErrors): void
{
    if (isGameWin($countAttempts, $countErrors)) {
        echo "==========================================" . PHP_EOL;
        echo "Победа! Все буквы угаданы" . PHP_EOL;
        echo "Количество ошибок: $countErrors" . PHP_EOL;
        echo "==========================================" . PHP_EOL;
        echo PHP_EOL;
    } else {
        echo "==========================================" . PHP_EOL;
        echo "Ты проиграл! Загаданное слово:" . implode('', $hiddenWord) . PHP_EOL;
        echo "==========================================" . PHP_EOL;
        echo PHP_EOL;
    }
}

function openLetter(array &$maskedWord, array $hiddenWord, string $letter): void
{
    for ($i = 0; $i < count($hiddenWord); $i++) {
        if ($hiddenWord[$i] == $letter) {
            $maskedWord[$i] = $letter;
        }
    }
}

function isGameEnd(array $maskedWord, int $countAttempts, int $countErrors): bool
{
    return $countAttempts == $countErrors || !in_array("[*]", $maskedWord);
}

function isGameWin(int $countAttempts, int $countErrors): bool
{
    return $countAttempts > $countErrors;
}

function startNewGame(string $hiddenWord): void
{
    $hiddenWord = mb_str_split($hiddenWord);
    $maskedWord = array_fill(0, count($hiddenWord), '[*]');

    $countAttempts = 6;
    $countErrors = 0;

    $usedLetters = [];

    while (!isGameEnd($maskedWord, $countAttempts, $countErrors)) {
        $userInput = mb_strtolower(readline("Введите букву-> "));

        if (!preg_match("/^[А-Яа-яЁё]+$/u", $userInput) || !(mb_strlen($userInput) == 1)) {
            echo "Для ввода доступны только русские буквы" . PHP_EOL;
            continue;
        }

        if (!in_array($userInput, $usedLetters)) {
            if (in_array($userInput, $hiddenWord)) {
                echo "Угадал!" . PHP_EOL;
                openLetter($maskedWord, $hiddenWord, $userInput);
            } else {
                echo "!!!Такой буквы нет в слове!!!" . PHP_EOL;
                $countErrors++;
            }
            $usedLetters[] = $userInput;
        } else {
            echo "!!!Такая буква уже была использована!!!" . PHP_EOL;
        }

        showGameStatus($usedLetters, $maskedWord, $countErrors);
    }

    showGameResult($hiddenWord, $countAttempts, $countErrors);
}

function start(): void
{
    showMenu();
    $menuItem = readline("Выберите пункт меню-> ");
    changeItemMenu($menuItem);
}

function changeItemMenu(mixed $menuItem): void
{
    switch ($menuItem) {
        case 1:
            $words = file('russian_nouns.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $randomWord = $words[array_rand($words)];
            startNewGame($randomWord);

            start();
            break;
        case 2:
            return;
        default:
            echo "Такого пункта нет!" . PHP_EOL;
            start();
    }
}

start();
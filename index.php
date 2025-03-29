<?php


function get_hangman_state(int $hangmanState = 0): string
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
    ",
        "
      +---+
      |   |
      O   |
          |
          |
          |
    =========
    ",
        "
      +---+
      |   |
      O   |
      |   |
          |
          |
    =========
    ",
        "
      +---+
      |   |
      O   |
     /|   |
          |
          |
    =========
    ",
        "
      +---+
      |   |
      O   |
     /|\  |
          |
          |
    =========
    ",
        "
      +---+
      |   |
     [O]  |
     /|\  |
     / \  |
          |
    =========
    ",
    ];

    return $states[$hangmanState];
}

function showMenu(): void
{
    echo "Добро пожаловать!";
    echo "1. Начать новую игру";
    echo "2. Выход";
}

function changeItemMenu(int $menuItem): void
{
    switch ($menuItem) {
        case 1:
            return;
        case 2:
            return;
        default:
            showMenu();
    }
}

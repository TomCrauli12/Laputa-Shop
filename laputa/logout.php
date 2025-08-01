<?

session_start();
session_destroy();
Header('Location: /');

//схватывает запущеннуюю сессию и позволяет еее завершить

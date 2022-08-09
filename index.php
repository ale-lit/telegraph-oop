<?php

require_once 'autoload.php';

const STORAGE_DIR = 'storage';
if (!file_exists('storage')) {
    mkdir('storage');
}

// $newObject = new FileStorage();

// $newPost = new TelegraphText('Павел', 'test_text_file.txt');
// $newPost->editText('Первый пост', 'Первый текст');
// $newPost->storeText();
// echo $newPost->loadText();
// $newPost->published = '12.03.2022';
// echo $newPost->published;

// Создание
// $te = new TelegraphText('Гоша', 'testt');
// $test = new FileStorage();
// $test->create($te);

// Чтение
// print_r($test->read('test_2022-08-04'));

// Изменение
// $test->update('test_2022-08-04', $te);

// Удаление
// $test->delete('test_2022-08-04');

// Список всех файлов
// print_r($test->list());

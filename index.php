<?php

require_once 'autoload.php';

const STORAGE_DIR = 'storage';
if (!file_exists('storage')) {
    mkdir('storage');
}

$newObject = new FileStorage();

// $newObject->backup();
$newObject->restoreBackup('backup_13-08-2022_13-34-45.json');


// $newPost = new TelegraphText('Павел', 'test_text_file');
// $newPost->text = 'fgdfgdfgdfgdfgdfg';
// $newPost->editText('Первый пост', 'Первый текст');
// print_r($newPost);
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

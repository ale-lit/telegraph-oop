<?php

const STORAGE_DIR = 'storage';
if(!file_exists('storage')) mkdir('storage');

class Text
{
    public $title;
    public $text;
    public $author;
    public $slug;
    public $published;

    public function __construct(string $author, string $slug)
    {   
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date('Y-m-d H:i:s');
    }

    public function storeText(): void
    {
        $data = [
            'title' => $this->title,
            'text' => $this->text,
            'author' => $this->author,
            'published' => $this->published,
        ];

        if (!file_exists($this->slug)) {
            file_put_contents($this->slug, serialize($data));
        }
    }

    public function loadText(): string
    {
        if (file_exists($this->slug) && filesize($this->slug) > 0) {
            $savedData = unserialize(file_get_contents($this->slug));

            $this->title = $savedData['title'];
            $this->text = $savedData['text'];
            $this->author = $savedData['author'];
            $this->published = $savedData['published'];

            return $this->text;
        }
    }

    public function editText(string $title, string $text): void
    {
        $this->title = $title;
        $this->text = $text;
    }
}

// $newPost = new Text('Павел', 'test_text_file.txt');
// $newPost->editText('Первый пост', 'Первый текст');
// $newPost->storeText();
// echo $newPost->loadText();

abstract class Storage
{
    abstract public function create(Text $object): string;
    abstract public function read(string $slug): Text;
    abstract public function update(string $slug, Text $data): void;
    abstract public function delete(string $slug): void;
    abstract public function list(): array;
}

abstract class View
{
    public $storage;

    public function __construct(Storage $object)
    {
        $this->storage = $object;
    }

    abstract public function displayTextById(string $id): string;
    abstract public function displayTextByUrl(string $url): string;
}

abstract class User
{
    public $id;
    public $name;
    public $role;

    abstract public function getTextsToEdit();
}

class FileStorage extends Storage
{
    public function create(Text $object): string
    {
        $fileName = $object->slug . '_' . date('Y-m-d');
        if (file_exists(STORAGE_DIR . '/' . $fileName . '.txt')) {
            $i = 0;
            do {
                $i++;
                $fileNameConflict = $fileName . '_' . $i;
            } while (file_exists(STORAGE_DIR . '/' . $fileNameConflict . '.txt'));
            $fileName = $fileNameConflict;     
        }
        $object->slug = $fileName;

        $data = [
            'title' => $object->title,
            'text' => $object->text,
            'author' => $object->author,
            'published' => $object->published,
            'slug' => $object->slug,
        ];

        file_put_contents(STORAGE_DIR . '/' . $fileName . '.txt', serialize($data));
        return $fileName;
    }

    public function read(string $slug): Text
    {
        $fileName = STORAGE_DIR . '/' . $slug . '.txt';        
        if (file_exists($fileName) && filesize($fileName) > 0) {
            $savedData = unserialize(file_get_contents($fileName));
            $post = new Text($savedData['author'], $savedData['slug'], $this);
            return $post;
        } else {
            return false;
        }
    }

    public function update(string $slug, Text $data): void
    {
        file_put_contents(STORAGE_DIR . '/' . $slug . '.txt', serialize($data));
    }

    public function delete(string $slug): void
    {
        $file = STORAGE_DIR . '/' . $slug . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function list(): array
    {
        $allFiles = array_diff(scandir(STORAGE_DIR), array('..', '.'));
        $result = [];
        foreach ($allFiles as $file) {
            $result[] = unserialize(file_get_contents(STORAGE_DIR . '/' . $file));
        }
        return $result;
    }
}

// Создание
// $te = new Text('Гоша', 'test');
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

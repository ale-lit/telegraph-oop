<?php

const STORAGE_DIR = 'storage';

if(!file_exists('storage')) mkdir('storage');

class Text
{
    public $title;
    public $text;
    public $author;
    public $published;
    public $slug;

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

$newPost = new Text('Павел', 'test_text_file.txt');
$newPost->editText('Первый пост', 'Первый текст');
$newPost->storeText();
echo $newPost->loadText();


abstract class Storage
{
    abstract public function create(Text $object): string;
    abstract public function read(string $slug): Text;
    abstract public function update(string $slug, self $data): void;
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
        ];

        file_put_contents(STORAGE_DIR . '/' . $fileName . '.txt', serialize($data));
        return $fileName;
    }

    public function read(string $slug): Text
    {
        $fileName = $slug . '.txt';
        if (file_exists(STORAGE_DIR . '/' . $fileName) && filesize(STORAGE_DIR . '/' . $fileName) > 0) {
            return new Text('', $fileName);
        } else {
            return false;
        }
    }

    // TODO: доделать
    public function update(string $slug, $data): void
    {
        file_put_contents($slug, serialize($data));
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
        $allFiles = scandir(STORAGE_DIR);
        return $allFiles;
    }
}


$te = new Text('Pyer', 'papapa');
$test = new FileStorage();
// $test->create($te);
print_r($test->read('papapa_2022-08-04_3'));

// Удаление
$test->delete('papapa_2022-08-04_2');


<?php

class FileStorage extends Storage
{
    function logMessage(string $error): void
    {
    }

    function lastMessages(int $num): array
    {
        $example = [];
        return $example;
    }

    function attachEvent(string $className, callable $callback): void
    {
    }

    function detouchEvent(string $className): void
    {
    }

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

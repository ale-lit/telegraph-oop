<?php

class FileStorage extends Storage
{
    public function logMessage(string $error): void
    {
    }

    public function lastMessages(int $num): array
    {
        $example = [];
        return $example;
    }

    public function attachEvent(string $className, callable $callback): void
    {
    }

    public function detouchEvent(string $className): void
    {
    }

    public function create(TelegraphText $object): string
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

    public function read(string $slug): TelegraphText
    {
        $fileName = STORAGE_DIR . '/' . $slug . '.txt';        
        if (file_exists($fileName) && filesize($fileName) > 0) {
            $savedData = unserialize(file_get_contents($fileName));
            $post = new TelegraphText($savedData['author'], $savedData['slug']);
            return $post;
        }
    }

    public function update(string $slug, TelegraphText $data): void
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
            $result[$file] = unserialize(file_get_contents(STORAGE_DIR . '/' . $file));
        }
        return $result;
    }

    public function backup()
    {
        $json = json_encode($this->list());
        $dt = new DateTime();
        file_put_contents('backup/backup_' . $dt->format('d-m-Y_H-i-s') . '.json', $json);
    }

    public function restoreBackup(string $backupName)
    {
        if (file_exists('backup/' . $backupName)) {
            $json = file_get_contents('backup/' . $backupName);
            $backupData = json_decode($json, true);

            foreach ($backupData as $fileName => $data) {
                file_put_contents('storage/' . $fileName, serialize($data));
            }
        }
    }
}

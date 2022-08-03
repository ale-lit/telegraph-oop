<?php

class TelegraphText
{
    private $title;
    private $text;
    private $author;
    private $published;
    private $slug;

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

$newPost = new TelegraphText('Павел', 'test_text_file.txt');
$newPost->editText('Первый пост', 'Первый текст');
$newPost->storeText();
echo $newPost->loadText();

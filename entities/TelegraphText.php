<?php

class TelegraphText
{
    private $text;
    private $title;
    private $author;
    private $published;
    private $slug;

    public function __construct(string $author, string $slug)
    {   
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date('Y-m-d H:i:s');
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'author':
                if (strlen($value) > 120) {
                    echo 'Ошибка! Поле author не должно быть больше 120 символов' . PHP_EOL;
                    return;
                }
                $this->author = $value;
                break;

            case 'slug':
                $pattern = '/[^A-Za-z0-9-_\/]/';
                if (preg_match($pattern, $value)) {
                    echo 'Ошибка! Поле slug может содержать только буквы латинского алфавита, цифры, и символы (тире, нижнее подчеркивание, слэш)' . PHP_EOL;
                    return;
                }
                $this->slug = $value;
                break;

            case 'published':
                if (strtotime($value) < date('U')) {
                    echo 'Ошибка! Поле published задано не корректно. Дата должна быть больше или равна текущей.' . PHP_EOL;
                    return;
                }
                $this->published = $value;
                break;

            case 'text':
                $this->text = $value;
                $this->storeText();
                break;
            
            default:
                return;
        }
    }

    public function __get($name)
    {
        if ($name === 'text') {
            return $this->loadText();
        } else {
            return $this->$name;
        }
    }

    private function storeText(): void
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

    private function loadText(): string
    {
        return $this->text;
        // if (file_exists($this->slug) && filesize($this->slug) > 0) {
        //     $savedData = unserialize(file_get_contents($this->slug));

        //     $this->title = $savedData['title'];
        //     $this->text = $savedData['text'];
        //     $this->author = $savedData['author'];
        //     $this->published = $savedData['published'];

        //     return $this->text;
        // }
    }

    public function editText(string $title, string $text): void
    {        
        if (strlen($text) < 1 || strlen($text) > 500) {
            throw new Exception('Длина текста должна быть от 1 до 500 символов!');
        }
        $this->title = $title;
        $this->text = $text;
    }
}

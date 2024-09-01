<?php

declare(strict_types=1);

namespace App\Models;

use DateTime;
use DateTimeZone;
use Parsedown;

class Post
{
    private string $slug;
    private string $filePath;
    private ?string $category = null;
    private ?string $date = null;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
        $this->filePath = __DIR__ . '/../../content/posts/' . $slug . '.md';
    }

    public function exists(): bool
    {
        return file_exists($this->filePath);
    }

    public function getContent(): string
    {
        return file_get_contents($this->filePath);
    }

    public function getCategory(): ?string
    {
        if ($this->category === null) {
            $this->extractCategory();
        }
        return $this->category;
    }

    public function getDate(): string
    {
        if ($this->date === null) {
            $this->extractDate();
        }
        return $this->date;
    }

    private function extractCategory(): void
    {
        $content = $this->getContent();
        if (preg_match('/^Category:\s*(.+)$/m', $content, $matches)) {
            $this->category = trim($matches[1]);
        } else {
            $this->category = 'Uncategorized';
        }
    }

    private function extractDate(): void
    {
        $content = $this->getContent();
        if (preg_match('/^Date:\s*(\d{2}\/\d{2}\/\d{4})/m', $content, $matches)) {
            $date = DateTime::createFromFormat('d/m/Y', trim($matches[1]), new DateTimeZone('America/Guatemala'));
            if ($date) {
                $this->date = $date->format('d/m/Y');
            } else {
                $this->date = 'Fecha inválida';
            }
        } else {
            $this->date = 'Fecha no disponible';
        }
    }

    public function getSummary(int $length = 150): string
    {
        $content = $this->getContent();
        $content = preg_replace('/^Category:\s*.+$/m', '', $content);
        $content = preg_replace('/^Date:\s*.+$/m', '', $content);
        $content = preg_replace('/\{[^}]+\}/', '', $content);
    
        $parsedown = new Parsedown();
        $plainText = strip_tags($parsedown->text($content));
    
        $summary = substr($plainText, 0, $length);
        return strlen($plainText) > $length ? $summary . '...' : $summary;
    }

    public static function getAllPosts(): array
    {
        $files = glob(__DIR__ . '/../../content/posts/*.md');
        return array_map(fn($file) => basename($file, '.md'), $files);
    }
}

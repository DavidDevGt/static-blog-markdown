<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Post;
use ParsedownExtra;
use DateTime;
use DateTimeZone;

class BlogController
{
    private const POSTS_PER_PAGE = 10;

    public function index(): void
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $posts = Post::getAllPosts();
        $postDetails = [];

        foreach ($posts as $slug) {
            $post = new Post($slug);
            $postDetails[] = [
                'slug' => $slug,
                'title' => str_replace('_', ' ', $slug),
                'category' => $post->getCategory(),
                'date' => $post->getDate(),
                'summary' => $post->getSummary(225)
            ];
        }

        usort($postDetails, function ($a, $b) {
            $dateA = DateTime::createFromFormat('d/m/Y', $a['date']);
            $dateB = DateTime::createFromFormat('d/m/Y', $b['date']);
            return $dateB <=> $dateA;
        });

        $totalPosts = count($postDetails);
        $totalPages = (int)ceil($totalPosts / self::POSTS_PER_PAGE);

        // Verificar si la página solicitada está fuera de rango
        if ($page > $totalPages || $page < 1) {
            $this->render404();
            return;
        }

        $paginatedPosts = array_slice($postDetails, $offset, self::POSTS_PER_PAGE);

        require_once __DIR__ . '/../Views/posts/index.php';
    }

    public function show(string $slug): void
    {
        $post = new Post($slug);
        if (!$post->exists()) {
            $this->render404();
            return;
        }

        $postTitle = str_replace('_', ' ', $slug);
        $content = (new ParsedownExtra())->text($post->getContent());
        $date = $post->getDate();
        require_once __DIR__ . '/../Views/posts/show.php';
    }

    private function render404(): void
    {
        http_response_code(404);
        require __DIR__ . '/../Views/error/error404.php';
    }
}

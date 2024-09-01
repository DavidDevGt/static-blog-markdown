<?php ob_start(); ?>

<?php
require __DIR__ . '/../components/filter.php';
?>

<div class="posts-container">
    <?php foreach ($paginatedPosts as $post): ?>
        <div class="card post-card">
            <div class="card-content">
                <span class="tag is-primary-light"><?= htmlspecialchars($post['category']) ?></span><br>
                <a href="/post/<?= htmlspecialchars($post['slug']) ?>" class="text-blue-link title-link">
                    <?= htmlspecialchars($post['title']) ?>
                </a>
                <p><?= htmlspecialchars($post['summary']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="pagination-buttons">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="button is-info is-light">Más recientes</a>
    <?php endif; ?>
    
    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="button is-warning is-light">Más antiguos</a>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';

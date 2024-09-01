<?php ob_start(); ?>
<div class="button-container">
    <a href="/" class="button is-primary">
        <span class="icon">
            <i class="fa-solid fa-arrow-left"></i>
        </span>
    </a>
</div>
<article class="card markdown-content mt-4">
    <?= $content ?>
</article>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';

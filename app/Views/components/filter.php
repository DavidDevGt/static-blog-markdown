<?php
$categories = array_unique(array_map(fn($post) => $post['category'], $postDetails));
?>

<div class="filter-container box">
    <div class="field is-grouped is-grouped-centered">
        <label class="label filter-label" for="category-filter">Filtrar por categoría:</label>
        <div class="control">
            <div class="select">
                <select id="category-filter" class="filter-select" onchange="filterPosts()">
                    <option value="all">Todas las categorías</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    function filterPosts() {
        const filterValue = document.getElementById('category-filter').value;
        const cards = document.querySelectorAll('.post-card');
        
        cards.forEach(card => {
            const category = card.querySelector('.tag').textContent.trim();
            if (filterValue === 'all' || category === filterValue) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

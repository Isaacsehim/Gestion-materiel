<?php

if ($totalPages <= 1) return;
?>

<nav class="pagination" aria-label="Pagination">
  <?php for ($p = 1; $p <= $totalPages; $p++): ?>
    <a href="?page=<?= $p ?>" class="<?= $p === $currentPage ? 'current' : '' ?>"><?= $p ?></a>
  <?php endfor; ?>
</nav>


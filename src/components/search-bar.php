<form method="GET" class="search-bar">
  <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Rechercher...">
  <button type="submit"><i class="fas fa-search"></i></button>
</form>

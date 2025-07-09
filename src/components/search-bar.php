<div class="barre-recherche">
  <form method="GET" class="formulaire-recherche">
    <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Rechercher..." class="champ-recherche">
    <button type="submit" class="bouton-recherche">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div>


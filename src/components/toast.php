<div class="conteneur-toast">
  <?php if (isset($_GET['success'])): ?> 
    <div class="alerte alerte-succes">
      <?= htmlspecialchars($_GET['success']) ?>
    </div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alerte alerte-erreur">
      <?= htmlspecialchars($_GET['error']) ?>
    </div>
  <?php endif; ?>
</div>
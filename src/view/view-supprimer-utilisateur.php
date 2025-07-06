<?php require_once(__DIR__ . '/../template/header.php'); ?>
<main class="container">
  <h1>Suppression de compte</h1>
  <p>
    <?php if ($_SESSION['user_id'] == $utilisateur['id_utilisateurs']): ?>
      Êtes-vous sûr de vouloir <strong>supprimer votre compte</strong> ?<br>
      Cette action est <b>irréversible</b> et vous serez immédiatement déconnecté(e).
    <?php else: ?>
      Êtes-vous sûr de vouloir supprimer le compte de <b><?= htmlspecialchars($utilisateur['utilisateur_nom'] . ' ' . $utilisateur['utilisateur_prenom']) ?></b> (<?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?>) ?
    <?php endif; ?>
  </p>

  <?php if (!empty($erreur)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
  <?php endif; ?>

  <form method="get" action="">
    <input type="hidden" name="page" value="supprimer-utilisateur">
    <input type="hidden" name="id" value="<?= (int)$utilisateur['id_utilisateurs'] ?>">
    <input type="hidden" name="confirm" value="oui">
    <button type="submit" class="btn btn-delete">
      Oui, supprimer définitivement
    </button>
    <a href="/?page=utilisateurs" class="btn bouton-secondaire">Annuler</a>
  </form>
</main>
<?php require_once(__DIR__ . '/../template/footer.php'); ?>

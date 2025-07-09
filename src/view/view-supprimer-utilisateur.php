<?php require_once(__DIR__ . '/../template/header.php'); ?>

<main class="container-bento">
  <section class="card">
    <h1 class="titre-section">Suppression de compte</h1>

    <div class="message-info">
      <?php if ($_SESSION['user_id'] == $utilisateur['id_utilisateurs']): ?>
        <p>
          Êtes-vous sûr de vouloir <strong>supprimer votre compte</strong> ?<br>
          Cette action est <strong>irréversible</strong> et vous serez immédiatement déconnecté(e).
        </p>
      <?php else: ?>
        <p>
          Êtes-vous sûr de vouloir supprimer le compte de
          <strong><?= htmlspecialchars($utilisateur['utilisateur_nom'] . ' ' . $utilisateur['utilisateur_prenom']) ?></strong>
          (<?= htmlspecialchars($utilisateur['utilisateur_pseudo']) ?>) ?
        </p>
      <?php endif; ?>
    </div>

    <?php if (!empty($erreur)): ?>
      <div class="message-erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="post" action="" class="formulaire-ajout">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
      <input type="hidden" name="page" value="supprimer-utilisateur">
      <input type="hidden" name="id" value="<?= (int)$utilisateur['id_utilisateurs'] ?>">
      <input type="hidden" name="confirm" value="oui">

      <div class="flex justify-between items-center">
        <button type="submit" class="btn btn-danger" tabindex="0">
          <i class="fa fa-trash"></i> Oui, supprimer définitivement
        </button>
        <a href="/?page=utilisateurs" class="btn btn-secondaire" tabindex="0">
          <i class="fa fa-times"></i> Annuler
        </a>
      </div>
    </form>
  </section>
</main>

<?php require_once(__DIR__ . '/../template/footer.php'); ?>

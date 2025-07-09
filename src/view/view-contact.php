<?php require_once(SRC_PATH . '/template/header.php'); ?>

<main class="section container-bento">
  <section class="card flex flex-col">
    <h1 class="alert alerte-succes" role="status">Contactez-nous</h1>

    <div class="message-info">
      <p><strong>Orchi</strong><br>
        32 Quai Southampton<br>
        76600 Le Havre<br>
        France
      </p>
      <p>
        <strong>Email :</strong> <a href="mailto:contact@orchi.fr" tabindex="0">contact@orchi.fr</a><br>
        <strong>Téléphone :</strong> <a href="tel:+33235123456" tabindex="0">02 35 12 34 56</a>
      </p>
    </div>

    <form method="post" action="#" class="formulaire-ajout">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

      <div class="champ-formulaire">
        <label for="nom" class="label-formulaire">Votre nom :</label>
        <input type="text" name="nom" id="nom" required tabindex="0">
      </div>

      <div class="champ-formulaire">
        <label for="email" class="label-formulaire">Votre email :</label>
        <input type="email" name="email" id="email" required tabindex="0">
      </div>

      <div class="champ-formulaire">
        <label for="message" class="label-formulaire">Votre message :</label>
        <textarea name="message" id="message" rows="5" required tabindex="0"></textarea>
      </div>

      <div class="flex flex-row justify-between items-center">
        <button type="submit" class="btn btn-validation btn-submit" tabindex="0">Envoyer</button>
      </div>
    </form>

    <p class="message-info">Aucune donnée n'est conservée via ce formulaire (démo).</p>
  </section>
</main>

<?php require_once(SRC_PATH . '/template/footer.php'); ?>
  <?php require_once(SRC_PATH . '/template/header.php'); ?>
  <main class="section container">
    <h1>Contactez-nous</h1>
    <div class="zone-interaction">
      <p>
        <strong>Orchi</strong><br>
        32 Quai Southampton<br>
        76600 Le Havre<br>
        France
      </p>
      <p>
        <strong>Email :</strong> <a href="mailto:contact@orchi.fr">contact@orchi.fr</a><br>
        <strong>Téléphone :</strong> <a href="tel:+33235123456">02 35 12 34 56</a>
      </p>
      <hr>
      <form method="post" action="#">
        <label for="nom">Votre nom :</label>
        <input type="text" name="nom" id="nom" required>
        <label for="email">Votre email :</label>
        <input type="email" name="email" id="email" required>
        <label for="message">Votre message :</label>
        <textarea name="message" id="message" rows="5" required></textarea>
        <button type="submit" class="bouton">Envoyer</button>
      </form>
      <p>Aucune donnée n'est conservée via ce formulaire (c pour la démo tmtc).</p>
    </div>
  </main>
  <?php require_once(SRC_PATH . '/template/footer.php'); ?>

<?php if (isset($_SESSION['user_id'])): ?>
<aside class="sidebar">
  <div class="sidebar-user flex flex-row items-center">
    <img src="<?= htmlspecialchars($_SESSION['utilisateur_photo'] ?? '/assets/images/utilisateurs/default.jpg') ?>"
         alt="Photo de profil"
         class="user-photo"
         id="photoProfil"
         loading="lazy">
    <div class="user-info flex flex-col">
      <p class="user-name">
        <?= htmlspecialchars($_SESSION['user'] ?? 'Pseudo') ?>
      </p>
      <p class="user-role">
        <?= htmlspecialchars($_SESSION['niveau'] ?? 'Rôle') ?>
      </p>
    </div>
  </div>

  <nav class="sidebar-nav" aria-label="Menu utilisateur">
    <ul class="flex flex-col">
      <li><a href="/?page=dashboard" tabindex="0"><i class="fas fa-chart-line"></i> Tableau de bord</a></li>
      <li><a href="/?page=profil-utilisateur" tabindex="0"><i class="fas fa-user"></i> Mon compte</a></li>
      <li><a href="/?page=favoris" tabindex="0"><i class="fas fa-star"></i> Favoris</a></li>
      <li><a href="/?page=deconnexion" tabindex="0"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>
  </nav>
</aside>
<?php endif; ?>

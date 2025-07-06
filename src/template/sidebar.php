<?php if (isset($_SESSION['user_id'])): ?>
<aside class="sidebar">
  <div class="sidebar-user">
    <img src="<?= htmlspecialchars($_SESSION['utilisateur_photo'] ?? '/assets/images/utilisateurs/default.jpg') ?>"
         alt="Photo utilisateur"
         class="user-photo"
         id="sidebarPhoto">
    <div class="user-info">
      <p class="user-name">
        <?= htmlspecialchars($_SESSION['user'] ?? 'Pseudo') ?>
      </p>
      <p class="user-role">
        <?= htmlspecialchars($_SESSION['niveau'] ?? 'Rôle') ?>
      </p>
    </div>
  </div>
  <nav class="sidebar-nav">
    <ul>
      <li><a href="/?page=dashboard"><i class="fas fa-chart-line"></i> Tableau de bord</a></li>
      <li><a href="/?page=profil-utilisateur"><i class="fas fa-user"></i> Mon compte</a></li>
      <li><a href="/?page=favoris"><i class="fas fa-star"></i> Favoris</a></li>
      <li><a href="/?page=deconnexion"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>
  </nav>
</aside>
<?php endif; ?>

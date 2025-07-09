<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Orchi - Gestion de matériel</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/assets/icons/main-blanche/main-blanche-favicon.ico" />
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/main-blanche/main-blanche-favicon-16x16.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/main-blanche/main-blanche-favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/icons/main-blanche/main-blanche-android-chrome-192x192.png" />
  <link rel="icon" type="image/png" sizes="512x512" href="/assets/icons/main-blanche/main-blanche-android-chrome-512x512.png" />
  <link rel="apple-touch-icon" href="/assets/icons/main-blanche/main-blanche-apple-touch-icon.png" />
  <link rel="icon" href="/assets/icons/main-noir/main-noir-favicon.ico" media="(prefers-color-scheme: light)" />
  <link rel="icon" href="/assets/icons/main-blanche/main-blanche-favicon.ico" media="(prefers-color-scheme: dark)" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;400&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@800&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body>
  <header class="navbar">
    <div class="container-bento">
      <a href="/?page=accueil" class="navbar-logo" aria-label="Page d’accueil Orchi" tabindex="0">
        <img src="/assets/icons/logo-blanc/webp/projet-fil-rouge300x300-main-blanche.webp"
             alt="Logo Orchi"
             loading="lazy">
      </a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <button class="navbar-toggle" aria-label="Ouvrir ou fermer le menu" tabindex="0">
          <span class="barre"></span>
          <span class="barre"></span>
          <span class="barre"></span>
        </button>
      <?php endif; ?>

      <ul class="navbar-links flex flex-row items-center" role="navigation">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="/?page=produits" tabindex="0"><i class="fa-solid fa-box"></i> Produits</a></li>
          <li><a href="/?page=maintenance" tabindex="0"><i class="fa-solid fa-screwdriver-wrench"></i> Maintenance</a></li>
          <?php if (isset($_SESSION['niveau']) && $_SESSION['niveau'] === 'admin'): ?>
            <li><a href="/?page=notifications" tabindex="0"><i class="fa-solid fa-bell"></i> Notifications</a></li>
            <li><a href="/?page=utilisateurs" tabindex="0"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>

      <?php if (isset($_SESSION['user_id'])): ?>
        <button class="navbar-avatar" aria-label="Ouvrir le menu utilisateur" tabindex="0">
          <img src="<?= htmlspecialchars($_SESSION['utilisateur_photo'] ?? '/assets/images/utilisateurs/default.jpg') ?>"
               alt="Photo utilisateur"
               class="user-photo"
               id="navbarAvatar"
               loading="lazy">
        </button>
      <?php endif; ?>
    </div>
  </header>

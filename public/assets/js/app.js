document.addEventListener("DOMContentLoaded", () => {

  const navbarToggle = document.querySelector('.navbar-toggle');
  const navbarLinks = document.querySelector('.navbar-links');

  if (navbarToggle && navbarLinks) {
    navbarToggle.addEventListener('click', () => {
      navbarToggle.classList.toggle('active');
      navbarLinks.classList.toggle('active');
    });

    navbarLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navbarToggle.classList.remove('active');
        navbarLinks.classList.remove('active');
      });
    });
  }


  const sidebar = document.querySelector('.sidebar');
  const navbarAvatar = document.getElementById('navbarAvatar');
  const sidebarPhoto = document.getElementById('sidebarPhoto');

  if (sidebar && navbarAvatar) {
    navbarAvatar.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });
  }
  if (sidebar && sidebarPhoto) {
    sidebarPhoto.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });
  }

function showToast(message, type = 'success', duration = 3000) {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = `toast toast-${type}`;
  toast.textContent = message;

  container.appendChild(toast);

  void toast.offsetWidth;
  toast.classList.add('show');

  toast.addEventListener('click', () => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  });

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, duration);
}

window.showToast = showToast;

});




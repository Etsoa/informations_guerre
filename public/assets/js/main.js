document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('.nav-links');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('active');
            toggle.classList.toggle('active');
        });
    }

    const adminToggle = document.querySelector('.admin-nav-toggle');
    const adminNav = document.querySelector('.admin-nav');
    const adminUserControls = document.querySelector('.user-controls');
    if (adminToggle && adminNav) {
        adminToggle.addEventListener('click', () => {
            adminNav.classList.toggle('active');
            adminToggle.classList.toggle('active');
            if (adminUserControls) {
                adminUserControls.classList.toggle('active');
            }
        });
    }
});

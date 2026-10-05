import '../css/portfolio.css';

const mobileToggle = document.getElementById('mobileToggle');
const navLinks = document.getElementById('navLinks');

mobileToggle?.addEventListener('click', () => navLinks?.classList.toggle('show'));
navLinks?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => navLinks.classList.remove('show'));
});

document.querySelectorAll('[data-filter]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-filter]').forEach((item) => item.classList.remove('active'));
        button.classList.add('active');
        const filter = button.dataset.filter;
        document.querySelectorAll('.project-card[data-category]').forEach((card) => {
            card.hidden = filter !== 'all' && card.dataset.category !== filter;
        });
    });
});

document.querySelectorAll('[data-skill-category]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('#skillsTabs [data-skill-category]').forEach((item) => item.classList.remove('active'));
        button.classList.add('active');
        const category = button.dataset.skillCategory;
        document.querySelectorAll('#skillsContainer .skill-card').forEach((card) => {
            card.hidden = category !== 'all' && card.dataset.skillCategory !== category;
        });
    });
});

window.addEventListener('scroll', () => {
    const scrollY = window.pageYOffset;

    document.querySelectorAll('section[id]').forEach((section) => {
        const link = document.querySelector(`.nav-link[href="#${section.id}"]`);
        if (!link) return;
        const active = scrollY > section.offsetTop - 120 && scrollY <= section.offsetTop - 120 + section.offsetHeight;
        link.classList.toggle('active', active);
    });
});

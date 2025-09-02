document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle-checkbox');
    const html = document.documentElement;
    const themeTexts = document.querySelectorAll('.theme-switcher__text');

    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    
    if (savedTheme === 'dark') {
        themeToggle.checked = true;
    }
    
    updateThemeText(savedTheme);
    
    themeToggle.addEventListener('change', toggleTheme);
    
    function toggleTheme() {
        const newTheme = themeToggle.checked ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeText(newTheme);
    }
    
    function updateThemeText(theme) {
        themeTexts[0].style.opacity = theme === 'light' ? '1' : '0.5';
        themeTexts[1].style.opacity = theme === 'dark' ? '1' : '0.5';
    }
});
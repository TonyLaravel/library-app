export function initializeTheme() {
    const stored = localStorage.theme;
    const prefers = matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = stored ? stored === 'dark' : prefers;      // honour system *until* user picks
    document.documentElement.classList.toggle('dark', isDark);
  }
  
  export function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    localStorage.theme = isDark ? 'dark' : 'light';
  }
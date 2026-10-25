/**
 * AUDRA HAVEN - MASTER JAVASCRIPT
 * Theme toggle (light/dark) dengan localStorage
 */

(function () {
    'use strict';

    const THEME_KEY = 'audra-theme';
    const DEFAULT_THEME = 'light';

    function getStoredTheme() {
        return localStorage.getItem(THEME_KEY) || DEFAULT_THEME;
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem(THEME_KEY, theme);
        updateToggleIcon(theme);
    }

    function updateToggleIcon(theme) {
        const btn = document.getElementById('themeToggle');
        if (!btn) return;
        btn.textContent = theme === 'dark' ? '☀️' : '🌙';
        btn.title = theme === 'dark' ? 'Mode Terang' : 'Mode Gelap';
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || DEFAULT_THEME;
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
    }

    // Terapkan tema SEGERA (hindari flash)
    applyTheme(getStoredTheme());

    // Expose
    window.AudraTheme = {
        toggle: toggleTheme,
        apply: applyTheme,
        getCurrent: () => document.documentElement.getAttribute('data-theme'),
    };

    // Pasang event listener setelah DOM siap
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('themeToggle');
        if (btn) {
            btn.addEventListener('click', toggleTheme);
        }
        updateToggleIcon(getStoredTheme());
    });

})();
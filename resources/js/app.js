import Alpine from "alpinejs";

Alpine.data("theme", () => ({
    isDark: false,
    open: false,

    init() {
        this.isDark = document.documentElement.classList.contains("dark");
    },

    toggle() {
        this.isDark = !this.isDark;
        document.documentElement.classList.toggle("dark", this.isDark);
        document.documentElement.style.colorScheme = this.isDark
            ? "dark"
            : "light";
        localStorage.setItem("theme", this.isDark ? "dark" : "light");
    },
}));

window.Alpine = Alpine;
Alpine.start();

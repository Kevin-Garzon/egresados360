/**
 * ===========================
 * Módulo de filtros dinámicos
 * ===========================
 */

document.addEventListener("DOMContentLoaded", () => {

    /**
     * Función general de filtrado
     * @param {string} tipoSelector - clase de los botones (ej: .filtro-btn)
     * @param {string} itemSelector - clase de los ítems a filtrar (ej: .curso-item)
     * @param {string} dataAttr - nombre del data-attribute (ej: data-categoria)
     */
    function activarFiltros(tipoSelector, itemSelector, dataAttr) {
        const botones = document.querySelectorAll(tipoSelector);
        const items = document.querySelectorAll(itemSelector);

        botones.forEach((btn) => {
            btn.addEventListener("click", (event) => {
                const categoria = event.target.textContent.trim().toLowerCase();

                // Limpiar estado anterior
                botones.forEach((b) =>
                    b.classList.remove("activo", "bg-primary", "text-white")
                );

                // Activar botón actual
                event.target.classList.add("activo", "bg-primary", "text-white");

                // Filtrar elementos
                items.forEach((item) => {
                    const categoriaItem = item.dataset[dataAttr];
                    if (categoria === "todos" || categoriaItem === categoria) {
                        item.classList.remove("hidden");
                    } else {
                        item.classList.add("hidden");
                    }
                });
            });
        });
    }

    // ========================
    // FORMACION
    // ========================
    if (document.querySelector(".filtro-btn")) {
        activarFiltros(".filtro-btn", ".curso-item", "categoria");
    }

    // ========================
    // EVENTOS (Bienestar)
    // ========================
    if (document.querySelector(".filtro-evento-btn")) {
        const botones = document.querySelectorAll(".filtro-evento-btn");
        const items = document.querySelectorAll(".evento-item");

        botones.forEach((btn) => {
            btn.addEventListener("click", (event) => {
                const filtro = event.target.dataset.filtro; // Leer data-filtro del botón

                // Limpiar estado anterior
                botones.forEach((b) =>
                    b.classList.remove("activo", "bg-primary", "text-white")
                );

                // Activar botón actual
                event.target.classList.add("activo", "bg-primary", "text-white");

                // Filtrar elementos
                items.forEach((item) => {
                    const tipoItem = item.dataset.tipo; // Leer data-tipo del evento
                    
                    if (filtro === "todos" || tipoItem === filtro) {
                        item.classList.remove("hidden");
                    } else {
                        item.classList.add("hidden");
                    }
                });
            });
        });
    }

});

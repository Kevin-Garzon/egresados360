document.addEventListener("DOMContentLoaded", () => {
    /* console.log("Tracking global cargado correctamente"); */

    // Escuchar clics en cualquier botón con data-track
    document.body.addEventListener("click", async (e) => {
        const btn = e.target.closest("[data-track]");
        if (!btn) return;

        e.preventDefault(); // Evita la acción directa hasta procesar

        const data = {
            module: btn.dataset.module,
            action: btn.dataset.action,
            item_type: btn.dataset.type,
            item_id: btn.dataset.id,
            item_title: btn.dataset.title,
            url: btn.getAttribute("href") || null,
        };

        const perfilId = localStorage.getItem("perfil_id");

        // Si el usuario no tiene perfil → abrir modal
        if (!perfilId) {
            /* console.log("No hay perfil guardado. Mostrando modal..."); */
            localStorage.setItem("pendiente_click", JSON.stringify(data));

            if (window.Livewire && typeof window.Livewire.dispatch === "function") {
                window.Livewire.dispatch("abrirFormularioPerfil");
            } else if (window.Livewire && typeof window.Livewire.emit === "function") {
                window.Livewire.emit("abrirFormularioPerfil");
            } else {
                /* console.warn("No se pudo abrir el modal de perfil (Livewire no disponible)."); */
            }
            return;
        }

        // Si sí hay perfil, registrar interacción directamente
        await registrarInteraccion({ ...data, perfil_id: perfilId });

        // Si el botón tiene una URL, abrirla en una nueva pestaña
        if (data.url) {
            window.open(data.url, "_blank");
        }

    });

    // Reintentar clic pendiente tras guardar perfil
    window.addEventListener("perfil-guardado", async () => {
        const pendiente = localStorage.getItem("pendiente_click");
        if (!pendiente) return;

        const data = JSON.parse(pendiente);
        data.perfil_id = localStorage.getItem("perfil_id");

        await registrarInteraccion(data);

        // Si tenía URL asociada, abrirla
        if (data.url) window.open(data.url, "_blank");

        localStorage.removeItem("pendiente_click");
    });

    // Función auxiliar
    async function registrarInteraccion(data) {
        try {
            await fetch("/api/track/interaction", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            });
            /* console.log("Interacción registrada:", data); */
        } catch (error) {
            console.error("Error registrando interacción:", error);
        }
    }
});

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

        // Registrar interacción y manejar posible redirección
        const response = await registrarInteraccion({ ...data, perfil_id: perfilId });

        if (response?.redirect) {
            // Si el backend devuelve un enlace (por ejemplo WhatsApp), redirigir directamente
            window.open(response.redirect, "_blank");
            return;
        }

        // Si no hay redirección especial, abrir URL normal (si existe)
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

        const response = await registrarInteraccion(data);

        // Si el backend devuelve redirección (WhatsApp, etc.)
        if (response?.redirect) {
            window.open(response.redirect, "_blank");
        } else if (data.url) {
            // Si no hay redirect, abrir la URL normal
            window.open(data.url, "_blank");
        }

        localStorage.removeItem("pendiente_click");
    });

    // Función auxiliar: registrar interacción vía API
    async function registrarInteraccion(data) {
        try {
            const response = await fetch("/api/track/interaction", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            });
            return await response.json(); // Devuelve el JSON con 'redirect' si aplica
        } catch (error) {
            console.error("Error registrando interacción:", error);
            return null;
        }
    }
});

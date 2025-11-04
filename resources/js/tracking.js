document.addEventListener("DOMContentLoaded", () => {
    document.body.addEventListener("click", async (e) => {
        const btn = e.target.closest("[data-track]");
        if (!btn) return;

        e.preventDefault();

        const data = {
            module: btn.dataset.module,
            action: btn.dataset.action,
            item_type: btn.dataset.type,
            item_id: btn.dataset.id,
            item_title: btn.dataset.title,
            url: btn.getAttribute("href") || null,
        };

        const perfilId = localStorage.getItem("perfil_id");

        // Si no hay perfil → guardamos el clic y abrimos el modal
        if (!perfilId) {
            localStorage.setItem("pendiente_click", JSON.stringify(data));

            if (window.Livewire?.dispatch) {
                window.Livewire.dispatch("abrirFormularioPerfil");
            } else if (window.Livewire?.emit) {
                window.Livewire.emit("abrirFormularioPerfil");
            }
            return;
        }

        // Con perfil existente → registrar y respetar redirect del backend
        const response = await registrarInteraccion({ ...data, perfil_id: perfilId });
        manejarRedireccion(response, data.url);
    });

    // Espera activa a que aparezca perfil_id en localStorage (race condition)
    async function waitForPerfilId(timeoutMs = 1500) {
        const start = Date.now();
        while (Date.now() - start < timeoutMs) {
            const id = localStorage.getItem("perfil_id");
            if (id) return id;
            await new Promise((r) => setTimeout(r, 100));
        }
        return null;
    }

    // Reintentar clic pendiente tras guardar perfil
    window.addEventListener("perfil-guardado", async (e) => {
        const pendiente = localStorage.getItem("pendiente_click");
        if (!pendiente) return;

        const data = JSON.parse(pendiente);

        // 1) Intentar tomar el perfil_id del detalle del evento
        let perfilId = e?.detail?.perfil_id || localStorage.getItem("perfil_id");

        // 2) Si aún no existe, esperamos un momento a que se escriba en localStorage
        if (!perfilId) {
            perfilId = await waitForPerfilId();
        }

        // 3) Si logramos obtener perfil_id → registramos y respetamos redirect
        if (perfilId) {
            data.perfil_id = perfilId;
            const response = await registrarInteraccion(data);
            manejarRedireccion(response, data.url);
        } else {
            // 4) Si de plano no hay perfil_id, como fallback abrimos la URL normal (evitamos bloqueo)
            if (data.url) window.open(data.url, "_blank");
        }

        localStorage.removeItem("pendiente_click");
    });

    // --- API: registrar interacción ---
    async function registrarInteraccion(data) {
        try {
            const res = await fetch("/api/track/interaction", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            });
            return await res.json();
        } catch (err) {
            console.error("Error registrando interacción:", err);
            return null;
        }
    }

    // --- Redirección centralizada ---
    function manejarRedireccion(response, urlFallback) {
        // Si el backend devuelve redirect (WhatsApp u otro), SIEMPRE priorizarlo
        if (response && typeof response.redirect === "string" && response.redirect.trim() !== "") {
            window.open(response.redirect, "_blank");
            return;
        }
        // Si no hay redirect especial, usar URL de respaldo (link del admin)
        if (urlFallback) {
            window.open(urlFallback, "_blank");
        }
    }
});

<footer id="footer" class="mt-16 border-t border-silver bg-primary text-white">
    <div class="container-app py-10 grid gap-8 md:grid-cols-4">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <!-- <span class="inline-block w-2.5 h-6 bg-primary rounded"></span> -->
                <span class="font-poppins text-lg font-bold text-gunmetal text-white">Egresados 360</span>
            </div>
            <p class="text-sm text-white">Portal de egresados de la FET. Información, formación, empleabilidad y bienestar del egresado.</p>
        </div>
        <div>
            <h3 class="font-poppins font-semibold text-gunmetal mb-3 text-white">Comunicaciones</h3>
            <ul class="space-y-1 text-sm">
                <li>Dirección: Kilometro 12 <br> Neiva - Rivera</li>
                <li>Email: <a class="underline" href="mailto:comunicaciones@fet.edu.co">ori-egresados@fet.edu.co</a></li>
                <li>WhatsApp: <a class="underline" href="tel:+573224650595">+57 322 4650595</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-poppins font-semibold text-gunmetal mb-3 text-white">Enlaces</h3>
            <ul class="space-y-2 text-sm">
                <li><a class="hover:underline" href="{{ url('/laboral') }}">Ofertas Laborales</a></li>
                <li><a class="hover:underline" href="{{ url('/formacion') }}">Formación Continua</a></li>
                <li><a class="hover:underline" href="{{ url('/bienestar') }}">Bienestar del Egresado</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-poppins font-semibold mb-3 text-white">Síguenos</h3>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="https://www.instagram.com/fetneiva/" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                        <i class="fab fa-instagram text-white"></i> Instagram
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/YoSoyFet" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                        <i class="fab fa-facebook-f text-white"></i> Facebook
                    </a>
                </li>
                <li>
                    <a href="https://www.tiktok.com/@yosoyfetneiva?lang=es" target="_blank" class="flex items-center gap-2 hover:underline text-white">
                        <i class="fab fa-tiktok text-white"></i> TikTok
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-silver/70 py-4 text-center text-xs text-white flex flex-col items-center gap-1">
        <span>© {{ date('Y') }} FET. Todos los derechos reservados — Egresados 360</span>

    </div>
</footer>
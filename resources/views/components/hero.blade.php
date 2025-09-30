@props([
'badge' => null, {{-- Texto de la etiqueta arriba --}}
'title' => '', {{-- Título principal --}}
'highlight' => '', {{-- Texto resaltado en verde --}}
'subtitle' => '', {{-- Texto adicional (segunda línea del título) --}}
'description' => '', {{-- Párrafo de apoyo --}}
'btnPrimary' => null, {{-- [ 'text' => '', 'icon' => '', 'link' => '' ] --}}
'btnSecondary' => null, {{-- Igual que el anterior --}}
'image' => null {{-- URL de la imagen --}}
])

<section class="relative overflow-hidden bg-white">
    <div class="container-app min-h-[calc(100vh-64.8px)] py-16 flex items-center lg:grid lg:grid-cols-2 gap-10">

        {{-- Columna de texto --}}
        <div>
            @if($badge)
            <span class="badge mb-4">{{ $badge }}</span>
            @endif

            <h1 class="text-4xl sm:text-5xl font-poppins font-semibold leading-tight text-gunmetal">
                {!! $title !!}
                @if($highlight)
                <br><span class="text-primary font-bold">{!! $highlight !!}</span>
                @endif
                @if($subtitle)
                <span class="block">{!! $subtitle !!}</span>
                @endif
            </h1>

            @if($description)
            <p class="mt-5 text-lg text-rblack/80 max-w-prose">
                {!! $description !!}
            </p>
            @endif

            <div class="mt-8 flex flex-wrap gap-3">
                @if($btnPrimary)
                <a href="{{ $btnPrimary['link'] ?? '#' }}" class="btn btn-primary">
                    @if(!empty($btnPrimary['icon'])) <i class="{{ $btnPrimary['icon'] }} text-white"></i>@endif
                    {{ $btnPrimary['text'] ?? '' }}
                </a>
                @endif

                @if($btnSecondary)
                <a href="{{ $btnSecondary['link'] ?? '#' }}" class="btn btn-secondary">
                    @if(!empty($btnSecondary['icon'])) <i class="{{ $btnSecondary['icon'] }} text-white"></i>@endif
                    {{ $btnSecondary['text'] ?? '' }}
                </a>
                @endif
            </div>
        </div>

        {{-- Columna de imagen --}}
        @if($image)
        <div>
            <div class="aspect-[4/3] md:aspect-[16/10] card p-2">
                <img src="{{ asset($image) }}" alt="Hero Image"
                    class="w-full h-full object-cover rounded-2xl" />
            </div>
        </div>
        @endif

    </div>
</section>
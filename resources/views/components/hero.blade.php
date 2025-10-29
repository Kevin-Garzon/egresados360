@props([
'badge' => null,
'title' => '',
'highlight' => '',
'subtitle' => '',
'description' => '',
'btnPrimary' => null,
'btnSecondary' => null,
'image' => null
])

<section class="relative overflow-hidden bg-white">
    <div
        class="container-app min-h-[calc(100vh-64.8px)] py-12 flex flex-col-reverse items-center justify-center gap-10 lg:grid lg:grid-cols-2 lg:py-16">

        {{-- Columna de texto --}}
        <div class="w-full text-center lg:text-left flex flex-col items-center lg:items-start">

            {{-- Badge --}}
            @if($badge)
            <span class="badge mb-4">{{ $badge }}</span>
            @endif

            <h1
                class="text-3xl sm:text-4xl lg:text-5xl font-poppins font-semibold leading-tight text-gunmetal max-w-xl">
                {!! $title !!}
                @if($highlight)
                <br><span class="text-primary font-bold">{!! $highlight !!}</span>
                @endif
                @if($subtitle)
                <span class="block">{!! $subtitle !!}</span>
                @endif
            </h1>

            @if($description)
            <p class="mt-5 text-base sm:text-lg text-rblack/80 max-w-prose px-3 lg:px-0">
                {!! $description !!}
            </p>
            @endif

            {{-- Botones (una sola fila) --}}
            <div class="mt-8 flex flex-row items-center gap-3 px-3 lg:px-0">
                @if($btnPrimary)
                <a href="{{ $btnPrimary['link'] ?? '#' }}"
                    class="btn btn-primary inline-flex items-center gap-2 !w-auto whitespace-nowrap shrink-0 px-5 py-3">
                    @if(!empty($btnPrimary['icon'])) <i class="{{ $btnPrimary['icon'] }} text-white"></i> @endif
                    {{ $btnPrimary['text'] ?? '' }}
                </a>
                @endif

                @if($btnSecondary)
                <a href="{{ $btnSecondary['link'] ?? '#' }}"
                    class="btn btn-secondary inline-flex items-center gap-2 !w-auto whitespace-nowrap shrink-0 px-5 py-3">
                    @if(!empty($btnSecondary['icon'])) <i class="{{ $btnSecondary['icon'] }} text-white"></i> @endif
                    {{ $btnSecondary['text'] ?? '' }}
                </a>
                @endif
            </div>

        </div>

        {{-- Columna de imagen --}}
        @if($image)
        <div class="w-full flex justify-center lg:justify-end">
            <div class="w-11/12 sm:w-4/5 md:w-11/12 lg:w-[100%] aspect-[4/3] md:aspect-[16/10] card p-2">
                <img src="{{ asset($image) }}" alt="Hero Image"
                    class="w-full h-full object-cover rounded-2xl shadow-lg" />
            </div>
        </div>
        @endif

    </div>
</section>
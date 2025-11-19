<div class="p-6 space-y-6">
    <h2 class="text-2xl font-poppins font-semibold text-gunmetal">
        <i class="fa-solid fa-robot mr-2 text-primary"></i> Informe Inteligente
    </h2>

    <p class="text-gray-600">
        Genera diferentes tipos de informes sobre la actividad del portal EGRESADOS 360:
        informes institucionales, comparativos, predictivos, por módulo específico y resúmenes express.
    </p>

    <div class="flex flex-col xl:flex-row items-start xl:items-end gap-6">

        {{-- Tipo de informe --}}
        <div class="space-y-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">
                Tipo de informe
            </label>
            <select
                wire:model.live="tipoInforme"
                class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-lg px-5 py-2.5 text-sm font-medium shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/40 focus:border-primary transition w-72 cursor-pointer">
                <option value="institucional">Informe institucional</option>
                <option value="comparativo">Informe comparativo</option>
                <option value="predictivo">Informe predictivo</option>
                <option value="modulo">Informe por módulo específico</option>
                <option value="express">Informe express resumido</option>

            </select>
        </div>

        {{-- Configuración del análisis (cambia según el tipo) --}}
        <div class="space-y-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">
                Configuración del análisis
            </label>

            @switch($tipoInforme)
            {{-- Institucional, por módulo y express usan PERIODO --}}
            @case('institucional')
            @case('modulo')
            @case('express')
            <select
                wire:model.live="periodo"
                class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-lg px-5 py-2.5 text-sm font-medium shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/40 focus:border-primary transition w-60 cursor-pointer">
                <option value="general">Todo el histórico</option>
                <option value="mes">Último mes</option>
                <option value="semana">Última semana</option>
                <option value="dia">Último día</option>
            </select>
            @break

            {{-- Comparativo usa TIPO DE COMPARACIÓN --}}
            @case('comparativo')
            <select
                wire:model.live="comparativo"
                class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-lg px-5 py-2.5 text-sm font-medium shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/40 focus:border-primary transition w-72 cursor-pointer">
                <option value="mes_vs_mes_anterior">Mes actual vs mes anterior</option>
                <option value="semana_vs_semana_anterior">Semana actual vs semana anterior</option>
                <option value="dia_vs_dia_semana_pasada">Día actual vs mismo día de la semana pasada</option>
            </select>
            @break

            {{-- Predictivo NO muestra filtros, solo una nota --}}
            @case('predictivo')
            <p class="text-xs text-gray-500 italic max-w-xs">
                Este informe se genera automáticamente con base en la trazabilidad de las métricas
                del portal. No requiere selección de periodo.
            </p>
            @break
            @endswitch
        </div>

        {{-- Módulo específico (solo cuando el tipo es "modulo") --}}
        @if($tipoInforme === 'modulo')
        <div class="space-y-1">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide">
                Módulo específico
            </label>
            <select
                wire:model.live="modulo"
                class="appearance-none bg-white border border-gray-300 text-gray-700 rounded-lg px-5 py-2.5 text-sm font-medium shadow-sm hover:border-primary focus:ring-2 focus:ring-primary/40 focus:border-primary transition w-60 cursor-pointer">
                <option value="laboral">Laboral</option>
                <option value="formacion">Formación Continua</option>
                <option value="bienestar">Bienestar del egresado</option>
            </select>
        </div>
        @endif

        {{-- Botones --}}
        <div class="flex gap-3 mt-2 xl:mt-0">
            <button
                wire:click="generarInforme"
                class="btn btn-primary flex items-center gap-2"
                wire:loading.attr="disabled">
                <i class="fa-solid fa-bolt"></i>
                <span wire:loading.remove>Generar Informe</span>
                <span wire:loading>Generando...</span>
            </button>

            @if($informe)
            <button
                wire:click="descargarPDF"
                class="btn bg-gray-700 text-white hover:bg-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Descargar PDF
            </button>
            @endif
        </div>
    </div>

    {{-- Contenedor del informe generado --}}
    @if($informe)
    <div class="bg-white border border-gray-200 rounded-2xl shadow-md px-10 py-8 mt-6 overflow-y-auto max-h-[75vh]">
        <h3 class="font-semibold text-lg mb-5 text-primary">Informe generado</h3>

        <div class="prose max-w-none text-gray-800 prose-headings:text-gunmetal prose-headings:font-semibold prose-h1:text-[1.5rem] prose-h2:text-[1.1rem] prose-p:leading-relaxed prose-p:text-[0.95rem] prose-li:text-[0.95rem] prose-h2:mt-8 prose-h3:mt-6">
            {!! $informe !!}
        </div>
    </div>
    @endif
</div>
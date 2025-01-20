<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Editor de Post - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://unpkg.com/grapesjs@0.22.5/dist/css/grapes.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/editor.js'])
    
    <!-- CodeMirror -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/hint/show-hint.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldgutter.min.css" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
    
    <!-- CodeMirror Addons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/closetag.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/closebrackets.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/matchbrackets.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/edit/matchtags.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/foldgutter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/brace-fold.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/fold/xml-fold.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/hint/show-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/hint/xml-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/hint/html-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/hint/css-hint.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/selection/active-line.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/comment/comment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/search/search.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/search/searchcursor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/dialog/dialog.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/addon/dialog/dialog.min.css" rel="stylesheet">
    
    <style>
    [x-cloak] { display: none !important; }
    
    /* Editor a pantalla completa */
    html, body {
        margin: 0;
        height: 100%;
        overflow: hidden;
    }
    
    #gjs {
        height: calc(100vh - 64px);
        margin-top: 64px;
        border: none;
    }

    /* Estilos del editor */
    .gjs-cv-canvas {
        width: 100%;
        height: 100%;
        top: 0;
    }
    
    .gjs-one-bg { background-color: white; }
    .gjs-one-color { color: #374151; }
    .gjs-two-bg { background-color: #2563eb; }
    .gjs-two-color { color: #2563eb; }
    .gjs-three-bg { background-color: #f9fafb; }
    .gjs-three-color { color: #4b5563; }
    
    /* Dark mode */
    .dark .gjs-one-bg { background-color: #1f2937; }
    .dark .gjs-one-color { color: #f3f4f6; }
    .dark .gjs-two-bg { background-color: #3b82f6; }
    .dark .gjs-two-color { color: #60a5fa; }
    .dark .gjs-three-bg { background-color: #111827; }
    .dark .gjs-three-color { color: #9ca3af; }
    
    /* Barra superior personalizada */
    .editor-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 64px;
        z-index: 50;
        background-color: white;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .dark .editor-header {
        background-color: #1f2937;
        border-color: #374151;
    }
    
    .editor-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100%;
        padding: 0 1rem;
    }
    
    /* Botones y controles */
    .editor-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.5rem;
        transition-property: color, background-color, border-color;
        transition-duration: 200ms;
    }
    
    .editor-btn-primary {
        background-color: #2563eb;
        color: white;
    }
    
    .editor-btn-primary:hover {
        background-color: #3b82f6;
    }
    
    .dark .editor-btn-primary {
        background-color: #3b82f6;
    }
    
    .dark .editor-btn-primary:hover {
        background-color: #60a5fa;
    }
    
    .editor-btn-secondary {
        background-color: white;
        color: #374151;
        border: 1px solid #d1d5db;
    }
    
    .editor-btn-secondary:hover {
        background-color: #f9fafb;
    }
    
    .dark .editor-btn-secondary {
        background-color: #1f2937;
        color: #e5e7eb;
        border-color: #4b5563;
    }
    
    .dark .editor-btn-secondary:hover {
        background-color: #374151;
    }

    /* Estilos para el contenido del editor */
    .gjs-content {
        max-width: 65ch;
        margin: 0 auto;
        padding: 2rem 1rem;
        line-height: 1.75;
    }

    .gjs-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }

    .gjs-content p {
        margin-bottom: 1.5rem;
        font-size: 1.125rem;
    }

    .gjs-content h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 3rem 0 1.5rem;
    }

    .gjs-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 2.5rem 0 1.25rem;
    }

    .gjs-content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 2rem 0 1rem;
    }

    /* Panel de dispositivos */
    .gjs-devices-c {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: transparent;
        padding: 0;
        border: none;
        height: auto;
        z-index: 1000;
    }

    .gjs-devices {
        display: inline-flex;
        gap: 0.25rem;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        padding: 0.5rem;
        border-radius: 100px;
        border: 1px solid rgba(229, 231, 235, 0.5);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease;
    }

    .gjs-devices:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-1px);
        box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.12), 0 3px 6px -1px rgba(0, 0, 0, 0.08);
    }

    .dark .gjs-devices {
        background: rgba(31, 41, 55, 0.9);
        border-color: rgba(55, 65, 81, 0.5);
    }

    .dark .gjs-devices:hover {
        background: rgba(31, 41, 55, 1);
    }

    .gjs-device-button {
        color: #6b7280;
        border: none;
        padding: 0.5rem;
        margin: 0;
        border-radius: 100px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        position: relative;
    }

    .gjs-device-button:hover {
        color: #374151;
        background: rgba(243, 244, 246, 0.8);
        transform: scale(1.05);
    }

    .dark .gjs-device-button {
        color: #9ca3af;
    }

    .dark .gjs-device-button:hover {
        color: #e5e7eb;
        background: rgba(55, 65, 81, 0.8);
    }

    .gjs-device-button.gjs-device-active {
        color: #2563eb;
        background: #eff6ff;
    }

    .dark .gjs-device-button.gjs-device-active {
        color: #60a5fa;
        background: rgba(30, 58, 138, 0.8);
    }

    /* Ocultar etiquetas de dispositivos */
    .gjs-device-label {
        display: none !important;
    }

    /* Ajustar tamaño de los iconos */
    .gjs-device-button svg {
        width: 18px;
        height: 18px;
    }

    /* Tooltips para los botones */
    .gjs-device-button::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
    }

    .gjs-device-button:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(-4px);
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1rem;
        border-top: 1px solid #374151;
    }

    .CodeMirror {
        height: 400px !important;
        font-size: 14px;
    }

    .gjs-mdl-dialog {
        max-width: 900px !important;
    }

    /* Estilos para el contenedor de bloques */
    .gjs-blocks-container {
        position: fixed;
        top: 64px;
        right: 0;
        bottom: 0;
        width: 280px;
        overflow-y: auto;
        z-index: 49;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
        transition: width 0.3s ease;
    }

    /* Ocultar resizer innecesario */
    .gjs-resizer-h:not(.gjs-resizer-h-cl) {
        display: none !important;
    }

    /* Estilo para el resizer activo */
    .gjs-resizer-h-cl {
        left: 0 !important;
        cursor: ew-resize;
    }

    /* Estilos para el contenedor de bloques */
    .gjs-blocks-container {
        position: fixed;
        top: 64px;
        right: 0;
        bottom: 0;
        width: 280px;
        overflow-y: auto;
        z-index: 50;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
    }

    /* Panel de herramientas */
    .gjs-pn-views-container {
        position: fixed;
        top: 64px;
        right: 280px;
        bottom: 0;
        width: 280px;
        overflow-y: auto;
        z-index: 50;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
    }

    /* Estilos para el contenedor de bloques */
    .gjs-blocks-container {
        position: fixed;
        top: 64px;
        right: 0;
        bottom: 0;
        width: 280px;
        overflow-y: auto;
        z-index: 49;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
        transition: width 0.3s ease;
    }

    /* Ocultar resizer innecesario */
    .gjs-resizer-h:not(.gjs-resizer-h-cl) {
        display: none !important;
    }

    /* Estilo para el resizer activo */
    .gjs-resizer-h-cl {
        left: 0 !important;
        cursor: ew-resize;
    }

    /* Modo oscuro */
    .dark .gjs-pn-views-container,
    .dark .gjs-blocks-container {
        background: rgba(31, 41, 55, 0.7);
        border-left: 1px solid rgba(55, 65, 81, 0.2);
    }

    .gjs-block {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        transition: all 0.3s ease;
    }

    .dark .gjs-block {
        background: rgba(0, 0, 0, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .gjs-block:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .dark .gjs-block:hover {
        background: rgba(0, 0, 0, 0.2) !important;
    }

    /* Estilos para las secciones del administrador de estilos */
    .gjs-sm-sector {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .dark .gjs-sm-sector {
        border-bottom: 1px solid rgba(55, 65, 81, 0.2) !important;
    }

    .gjs-sm-property {
        background: transparent !important;
    }

    /* Estilos para los inputs y selects */
    .gjs-field {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 4px !important;
    }

    .dark .gjs-field {
        background: rgba(0, 0, 0, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .gjs-field:focus-within {
        border-color: rgba(37, 99, 235, 0.5) !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25) !important;
    }

    /* Ajustes para el texto en la barra lateral */
    .gjs-pn-views-container {
        color: #374151 !important;
    }

    .dark .gjs-pn-views-container {
        color: #e5e7eb !important;
    }

    /* Scrollbar personalizada */
    .gjs-pn-views-container::-webkit-scrollbar {
        width: 6px;
    }

    .gjs-pn-views-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .gjs-pn-views-container::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.3);
        border-radius: 3px;
    }

    .dark .gjs-pn-views-container::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.2);
    }

    .gjs-block {
        width: calc(50% - 0.5rem);
        margin: 0.25rem;
        border-radius: 0.5rem;
        padding: 0.75rem;
        min-height: 90px;
        text-align: center;
        font-size: 0.875rem;
    }

    .gjs-block:hover {
        color: #2563eb;
    }

    .dark .gjs-block:hover {
        color: #60a5fa;
    }

    .gjs-block svg {
        width: 24px;
        height: 24px;
        margin: 0 auto 0.5rem;
    }

    .gjs-block-categories {
        padding: 0;
    }

    .gjs-block-category {
        margin-bottom: 1rem;
    }

    .gjs-block-category.gjs-open {
        border-bottom: 1px solid rgba(229, 231, 235, 0.5);
    }

    .dark .gjs-block-category.gjs-open {
        border-bottom-color: rgba(55, 65, 81, 0.5);
    }

    .gjs-title {
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.5rem 0;
        color: #374151;
    }

    .dark .gjs-title {
        color: #e5e7eb;
    }

    .gjs-blocks {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.5rem 0;
    }

    .gjs-preview-modal .gjs-mdl-dialog {
        max-width: 90% !important;
        max-height: 90vh !important;
        width: 90% !important;
    }
    
    .dark .gjs-preview-modal .gjs-mdl-dialog {
        background-color: #1f2937;
    }
    
    .dark .gjs-preview-modal div {
        background-color: #111827;
        color: #f3f4f6;
    }
    </style>
</head>
<body class="antialiased h-full">
    <!-- Barra superior -->
    <header class="editor-header">
        <div class="editor-header-content">
            <div class="flex items-center space-x-4">
                <a href="{{ route('filament.admin.resources.posts.edit', $post) }}" class="editor-btn editor-btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver al panel
                </a>
                <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Editando: {{ $post->title }}
                </h1>
            </div>
            <div class="flex items-center space-x-2">
                <button type="button" class="editor-btn editor-btn-secondary" id="btnPreview">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Vista previa
                </button>
                <button type="button" class="editor-btn editor-btn-primary" id="btnSave">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar cambios
                </button>
            </div>
        </div>
    </header>

    <!-- Contenedor del editor -->
    <div id="gjs"></div>
    
    <!-- Contenedor de bloques -->
    <div id="blocks" class="gjs-blocks-container"></div>

    <!-- Panel de herramientas -->
    <div class="gjs-pn-views-container"></div>

    <!-- Scripts -->
    <script src="https://unpkg.com/grapesjs@0.22.5/dist/grapes.min.js"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic@1.0.1/dist/grapesjs-blocks-basic.min.js"></script>
    <script src="https://unpkg.com/grapesjs-preset-webpage@1.0.2/dist/grapesjs-preset-webpage.min.js"></script>
    <script src="https://unpkg.com/grapesjs-custom-code@1.0.1/dist/grapesjs-custom-code.min.js"></script>
    <script src="https://unpkg.com/grapesjs-style-bg@2.0.1/dist/grapesjs-style-bg.min.js"></script>
    <script src="https://unpkg.com/grapesjs-tabs@1.0.6/dist/grapesjs-tabs.min.js"></script>
    <script src="https://unpkg.com/grapesjs-tooltip@0.1.7/dist/grapesjs-tooltip.min.js"></script>
    <script src="https://unpkg.com/grapesjs-parser-postcss@1.0.1/dist/grapesjs-parser-postcss.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/editor.js'])

    <script>
        // Detectar modo oscuro
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar editor con plugins adicionales
            const editor = grapesjs.init({
                container: '#gjs',
                height: '100%',
                width: 'auto',
                storageManager: false,
                // Configuración de idioma español
                i18n: {
                    locale: 'es',
                    messages: {
                        es: {
                            styleManager: {
                                empty: 'Seleccione un elemento para usar el Administrador de estilos',
                                layer: 'Capa',
                                fileButton: 'Imágenes',
                                sectors: {
                                    general: 'General',
                                    layout: 'Diseño',
                                    typography: 'Tipografía',
                                    decorations: 'Decoraciones',
                                    extra: 'Extra',
                                    flex: 'Flex',
                                    dimension: 'Dimensión'
                                },
                                properties: {
                                    float: 'Flotante',
                                    display: 'Mostrar',
                                    position: 'Posición',
                                    top: 'Arriba',
                                    right: 'Derecha',
                                    left: 'Izquierda',
                                    bottom: 'Abajo',
                                    width: 'Ancho',
                                    height: 'Alto',
                                    'max-width': 'Ancho máx',
                                    'max-height': 'Alto máx',
                                    margin: 'Margen',
                                    padding: 'Relleno',
                                    'font-family': 'Tipo de letra',
                                    'font-size': 'Tamaño de letra',
                                    'font-weight': 'Grosor',
                                    'letter-spacing': 'Espaciado',
                                    color: 'Color',
                                    'line-height': 'Interlineado',
                                    'text-align': 'Alineación',
                                    'text-shadow': 'Sombra del texto',
                                    'text-transform': 'Transformación',
                                    'border-radius': 'Radio del borde',
                                    border: 'Borde',
                                    'box-shadow': 'Sombra',
                                    background: 'Fondo',
                                    'background-color': 'Color de fondo'
                                }
                            },
                            traitManager: {
                                empty: 'Seleccione un elemento para usar el Administrador de rasgos',
                                label: 'Configuración de componente',
                                traits: {
                                    // Traducciones específicas para traits
                                    labels: {
                                        id: 'Identificador',
                                        alt: 'Texto alternativo',
                                        title: 'Título',
                                        href: 'Enlace'
                                    },
                                    attributes: {
                                        id: 'Identificador',
                                        class: 'Clase',
                                        src: 'Fuente',
                                        name: 'Nombre',
                                        placeholder: 'Marcador de posición',
                                        value: 'Valor'
                                    },
                                    options: {
                                        target: {
                                            false: 'Ventana actual',
                                            _blank: 'Nueva ventana'
                                        }
                                    }
                                }
                            },
                            panels: {
                                buttons: {
                                    title: 'Botones',
                                    labels: {
                                        preview: 'Vista previa',
                                        fullscreen: 'Pantalla completa',
                                        'sw-visibility': 'Ver componentes',
                                        'export-template': 'Ver código',
                                        'open-sm': 'Abrir administrador de estilos',
                                        'open-tm': 'Configuraciones',
                                        'open-layers': 'Abrir administrador de capas',
                                        'open-blocks': 'Abrir bloques'
                                    }
                                }
                            },
                            assetManager: {
                                addButton: 'Añadir imagen',
                                inputPlh: 'http://ruta-a-la-imagen.jpg',
                                modalTitle: 'Seleccionar imagen',
                                uploadTitle: 'Arrastre los archivos aquí o haga clic para cargar'
                            },
                            deviceManager: {
                                device: 'Dispositivo',
                                devices: {
                                    desktop: 'Escritorio',
                                    tablet: 'Tableta',
                                    mobile: 'Móvil',
                                    mobileLandscape: 'Móvil Horizontal'
                                }
                            },
                            components: {
                                labels: {
                                    component: 'Componente',
                                    components: 'Componentes',
                                    settings: 'Configuraciones',
                                    styles: 'Estilos',
                                    traits: 'Rasgos'
                                }
                            },
                            blockManager: {
                                labels: {
                                    // Categorías de bloques
                                    'Básicos': 'Básicos',
                                    'Contenedores': 'Contenedores',
                                    'Componentes': 'Componentes',
                                    'Secciones': 'Secciones',
                                    'Extra': 'Extra'
                                }
                            },
                            layers: {
                                empty: 'Seleccione un elemento para ver sus capas',
                                component: {
                                    unnamed: 'Sin nombre',
                                    root: 'Raíz'
                                }
                            },
                            modals: {
                                // Textos para modales
                                titles: {
                                    'export-template': 'Exportar plantilla',
                                    'save-template': 'Guardar plantilla',
                                    'import-component': 'Importar componente',
                                    'import-template': 'Importar plantilla'
                                },
                                labels: {
                                    'save': 'Guardar',
                                    'cancel': 'Cancelar',
                                    'delete': 'Eliminar',
                                    'close': 'Cerrar',
                                    'copy': 'Copiar',
                                    'paste': 'Pegar',
                                    'download': 'Descargar',
                                    'upload': 'Subir'
                                }
                            }
                        }
                    }
                },
                panels: {
                    defaults: [
                        {
                            id: 'views',
                            el: '.gjs-pn-views-container',
                            // Desactivar resizer para este panel
                            resizable: false,
                            buttons: [
                                {
                                    id: 'open-sm',
                                    className: 'fa fa-paint-brush',
                                    command: 'open-sm',
                                    active: true,
                                    attributes: {
                                        title: 'Estilos',
                                        'data-tooltip-pos': 'bottom'
                                    }
                                },
                                {
                                    id: 'open-tm',
                                    className: 'fa fa-cog',
                                    command: 'open-tm',
                                    attributes: {
                                        title: 'Ajustes',
                                        'data-tooltip-pos': 'bottom'
                                    }
                                },
                                {
                                    id: 'open-layers',
                                    className: 'fa fa-bars',
                                    command: 'open-layers',
                                    attributes: {
                                        title: 'Capas',
                                        'data-tooltip-pos': 'bottom'
                                    }
                                },
                                {
                                    id: 'edit-css',
                                    className: 'fa fa-code',
                                    command: 'css-edit',
                                    attributes: {
                                        title: 'Editar CSS',
                                        'data-tooltip-pos': 'bottom'
                                    }
                                }
                            ]
                        },
                        {
                            id: 'views-container',
                            el: '.gjs-pn-views-container',
                            // Desactivar resizer para este panel
                            resizable: false
                        },
                        {
                            id: 'blocks',
                            el: '#blocks',
                            // Configurar resizer solo para el panel de bloques
                            resizable: {
                                tc: false, // top center
                                cr: false, // center right
                                bc: false, // bottom center
                                cl: false,  // center left
                                minDim: 200,
                                maxDim: 400,
                                onEnd: () => {
                                    editor.refresh();
                                }
                            }
                        }
                    ]
                },
                plugins: [
                    'gjs-blocks-basic',
                    'gjs-preset-webpage',
                    'gjs-custom-code',
                    'gjs-style-bg',
                    'gjs-tabs',
                    'gjs-tooltip',
                    'gjs-parser-postcss'
                ],
                blockManager: {
                    appendTo: '#blocks',
                    blocks: [
                        // Categoría: Básicos
                        {
                            id: 'text',
                            label: 'Texto',
                            category: 'Básicos',
                            content: '<div data-gjs-type="text">Inserta tu texto aquí</div>',
                            attributes: { class: 'gjs-block-text' }
                        },
                        {
                            id: 'image',
                            label: 'Imagen',
                            category: 'Básicos',
                            content: { type: 'image' },
                            attributes: { class: 'gjs-block-image' }
                        },
                        {
                            id: 'link',
                            label: 'Enlace',
                            category: 'Básicos',
                            content: {
                                type: 'link',
                                content: 'Enlace',
                                attributes: { href: '#' }
                            },
                            attributes: { class: 'gjs-block-link' }
                        },
                        {
                            id: 'video',
                            label: 'Video',
                            category: 'Básicos',
                            content: {
                                type: 'video',
                                src: 'https://www.youtube.com/embed/your-video-id',
                                style: {
                                    width: '100%',
                                    height: '300px'
                                }
                            },
                            attributes: { class: 'gjs-block-video' }
                        },
                        // Categoría: Contenedores
                        {
                            id: 'container',
                            label: 'Contenedor',
                            category: 'Contenedores',
                            content: `<div class="container mx-auto px-4">
                                <div data-gjs-type="text">Contenido del contenedor</div>
                            </div>`,
                            attributes: { class: 'gjs-block-container' }
                        },
                        {
                            id: 'grid-2',
                            label: 'Grid 2 Columnas',
                            category: 'Contenedores',
                            content: `<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4"><div data-gjs-type="text">Columna 1</div></div>
                                <div class="p-4"><div data-gjs-type="text">Columna 2</div></div>
                            </div>`,
                            attributes: { class: 'gjs-block-grid' }
                        },
                        {
                            id: 'grid-3',
                            label: 'Grid 3 Columnas',
                            category: 'Contenedores',
                            content: `<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4"><div data-gjs-type="text">Columna 1</div></div>
                                <div class="p-4"><div data-gjs-type="text">Columna 2</div></div>
                                <div class="p-4"><div data-gjs-type="text">Columna 3</div></div>
                            </div>`,
                            attributes: { class: 'gjs-block-grid' }
                        },
                        // Categoría: Componentes
                        {
                            id: 'button',
                            label: 'Botón',
                            category: 'Componentes',
                            content: `<button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                Botón
                            </button>`,
                            attributes: { class: 'gjs-block-button' }
                        },
                        {
                            id: 'alert',
                            label: 'Alerta',
                            category: 'Componentes',
                            content: `<div class="p-4 mb-4 rounded-lg bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300" role="alert">
                                <div class="font-medium">¡Información importante!</div>
                                <div>Mensaje de la alerta aquí.</div>
                            </div>`,
                            attributes: { class: 'gjs-block-alert' }
                        },
                        {
                            id: 'card',
                            label: 'Tarjeta',
                            category: 'Componentes',
                            content: `<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                                <img class="w-full h-48 object-cover" src="https://via.placeholder.com/400x200" alt="Card image">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold mb-2">Título de la Tarjeta</h3>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">Descripción de la tarjeta aquí...</p>
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Leer más</button>
                                </div>
                            </div>`,
                            attributes: { class: 'gjs-block-card' }
                        },
                        // Categoría: Secciones
                        {
                            id: 'hero',
                            label: 'Hero',
                            category: 'Secciones',
                            content: `<section class="relative py-20 bg-gradient-to-r from-blue-600 to-indigo-600">
                                <div class="container mx-auto px-4 text-center text-white">
                                    <h1 class="text-5xl font-bold mb-4">Título Principal</h1>
                                    <p class="text-xl mb-8">Subtítulo o descripción aquí...</p>
                                    <div class="flex justify-center gap-4">
                                        <button class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100">
                                            Botón Principal
                                        </button>
                                        <button class="px-8 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600">
                                            Botón Secundario
                                        </button>
                                    </div>
                                </div>
                            </section>`,
                            attributes: { class: 'gjs-block-hero' }
                        },
                        {
                            id: 'features',
                            label: 'Características',
                            category: 'Secciones',
                            content: `<section class="py-16 bg-gray-50 dark:bg-gray-900">
                                <div class="container mx-auto px-4">
                                    <h2 class="text-3xl font-bold text-center mb-12">Nuestras Características</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-semibold mb-2">Característica 1</h3>
                                            <p class="text-gray-600 dark:text-gray-400">Descripción de la característica...</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-semibold mb-2">Característica 2</h3>
                                            <p class="text-gray-600 dark:text-gray-400">Descripción de la característica...</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-semibold mb-2">Característica 3</h3>
                                            <p class="text-gray-600 dark:text-gray-400">Descripción de la característica...</p>
                                        </div>
                                    </div>
                                </div>
                            </section>`,
                            attributes: { class: 'gjs-block-features' }
                        },
                        {
                            id: 'testimonial',
                            label: 'Testimonial',
                            category: 'Secciones',
                            content: `<div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg my-4">
                                <div class="flex items-center mb-4">
                                    <img class="w-12 h-12 rounded-full object-cover mr-4" src="https://via.placeholder.com/100" alt="Avatar">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Nombre del Cliente</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Cargo / Empresa</p>
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 italic">"Testimonio del cliente aquí..."</p>
                                <div class="mt-4 flex">
                                    <svg class="text-yellow-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <svg class="text-yellow-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <svg class="text-yellow-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <svg class="text-yellow-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <svg class="text-yellow-400 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            </div>`,
                            attributes: { class: 'gjs-block-testimonial' }
                        },
                        {
                            id: 'cta',
                            label: 'Llamada a la Acción',
                            category: 'Secciones',
                            content: `<section class="py-16 bg-gray-900 text-white">
                                <div class="container mx-auto px-4 text-center">
                                    <h2 class="text-4xl font-bold mb-4">¿Listo para comenzar?</h2>
                                    <p class="text-xl mb-8 text-gray-300">Subtítulo persuasivo aquí...</p>
                                    <div class="flex justify-center gap-4">
                                        <button class="px-8 py-3 bg-blue-600 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                            Comenzar Ahora
                                        </button>
                                        <button class="px-8 py-3 border-2 border-white rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                                            Saber Más
                                        </button>
                                    </div>
                                </div>
                            </section>`,
                            attributes: { class: 'gjs-block-cta' }
                        }
                    ]
                },
                pluginsOpts: {
                    'gjs-blocks-basic': {
                        blocks: ['column1', 'column2', 'column3', 'column3-7', 'text', 'link', 'image', 'video', 'map']
                    },
                    'gjs-preset-webpage': {
                        modalImportTitle: 'Importar Template',
                        modalImportLabel: 'Pega tu código HTML/CSS aquí:',
                        modalImportContent: '',
                        textCleanCanvas: 'Estás seguro de limpiar el canvas?',
                        blocks: ['link-block', 'quote', 'text-basic'],
                        navbarOpts: false,
                        countdownOpts: false,
                        formsOpts: false,
                        exportOpts: false,
                        aviaryOpts: false,
                        filestackOpts: false
                    },
                    'gjs-custom-code': {
                        blockLabel: 'Código Personalizado',
                        blockCustomCode: {
                            category: 'Extra',
                            label: 'Código Personalizado',
                            attributes: { class: 'fa fa-code' },
                            content: '<div data-gjs-type="custom-code" class="custom-code">Inserta tu código aquí</div>'
                        },
                        placeholderContent: '/* Escribe tu código personalizado aquí */',
                        toolbarBtnCustomCode: {
                            icon: '<svg>...</svg>',
                            attributes: { title: 'Editar Código' }
                        }
                    },
                    'gjs-style-bg': {
                        // Configuración para fondos y gradientes
                        addBackgroundGradient: true,
                        colorPicker: 'default',
                        defaultGradientColor: 'linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(0,0,0,1) 100%)'
                    },
                    'gjs-tabs': {
                        tabsBlock: {
                            category: 'Extra',
                            label: 'Pestañas',
                            attributes: { class: 'fa fa-folder' }
                        },
                        // Estilos predeterminados para las pestañas
                        style: `
                            .tabs-container { margin: 20px 0; }
                            .tabs-navigation { display: flex; margin-bottom: -1px; }
                            .tab-button { padding: 10px 20px; border: 1px solid #ddd; background: #f5f5f5; cursor: pointer; }
                            .tab-button.active { background: #fff; border-bottom-color: #fff; }
                            .tab-content { display: none; padding: 20px; border: 1px solid #ddd; }
                            .tab-content.active { display: block; }
                        `
                    },
                    'gjs-tooltip': {
                        // Configuración para tooltips
                        blockTooltip: {
                            category: 'Extra',
                            label: 'Tooltip',
                            attributes: { class: 'fa fa-comment' }
                        },
                        toolbarBtnTooltip: {
                            icon: '<svg>...</svg>',
                            attributes: { title: 'Añadir Tooltip' }
                        }
                    }
                },
                deviceManager: {
                    appendTo: '.gjs-devices-c',
                    devices: [
                        {
                            id: 'desktop',
                            name: 'Desktop',
                            width: '',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>`
                        },
                        {
                            id: 'tablet',
                            name: 'Tablet',
                            width: '768px',
                            widthMedia: '768px',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>`
                        },
                        {
                            id: 'mobile',
                            name: 'Mobile',
                            width: '360px',
                            widthMedia: '360px',
                            icon: `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>`
                        }
                    ]
                },
                domComponents: {
                    wrapper: {
                        removable: false,
                        draggable: false,
                        copyable: false,
                        tagName: 'div',
                        attributes: { id: 'main-content' }
                    }
                },
                canvas: {
                    styles: [
                        '{{ Vite::asset("resources/css/app.css") }}'
                    ],
                    scripts: []
                },
                styleManager: {
                    sectors: [
                        {
                            name: 'Dimensiones',
                            open: false,
                            properties: [
                                { name: 'width', label: 'Ancho' },
                                { name: 'height', label: 'Alto' },
                                { name: 'max-width', label: 'Ancho máximo' },
                                { name: 'min-height', label: 'Alto mínimo' },
                                { name: 'margin', label: 'Margen' },
                                { name: 'padding', label: 'Relleno' }
                            ]
                        },
                        {
                            name: 'Tipografía',
                            open: false,
                            properties: [
                                { 
                                    name: 'font-family', 
                                    label: 'Fuente',
                                    type: 'select',
                                    options: [
                                        { value: 'Arial, sans-serif', name: 'Arial' },
                                        { value: 'Inter, sans-serif', name: 'Inter' },
                                        { value: 'Georgia, serif', name: 'Georgia' },
                                        { value: 'monospace', name: 'Monospace' }
                                    ]
                                },
                                { 
                                    name: 'font-size', 
                                    label: 'Tamaño',
                                    type: 'select',
                                    options: [
                                        { value: '12px', name: 'Pequeño' },
                                        { value: '16px', name: 'Normal' },
                                        { value: '20px', name: 'Grande' },
                                        { value: '24px', name: 'Muy Grande' }
                                    ]
                                },
                                { 
                                    name: 'font-weight', 
                                    label: 'Peso',
                                    type: 'select',
                                    options: [
                                        { value: '300', name: 'Ligero' },
                                        { value: '400', name: 'Normal' },
                                        { value: '500', name: 'Medio' },
                                        { value: '600', name: 'Semi Negrita' },
                                        { value: '700', name: 'Negrita' }
                                    ]
                                },
                                { name: 'color', label: 'Color', type: 'color' },
                                { name: 'line-height', label: 'Altura de línea' },
                                { 
                                    name: 'text-align', 
                                    label: 'Alineación',
                                    type: 'radio',
                                    options: [
                                        { value: 'left', name: 'Izquierda' },
                                        { value: 'center', name: 'Centro' },
                                        { value: 'right', name: 'Derecha' },
                                        { value: 'justify', name: 'Justificado' }
                                    ]
                                },
                                { name: 'text-shadow', label: 'Sombra de texto' }
                            ]
                        },
                        {
                            name: 'Decoración',
                            open: false,
                            properties: [
                                { name: 'background-color', label: 'Color de fondo', type: 'color' },
                                { 
                                    name: 'border-radius', 
                                    label: 'Radio de borde',
                                    type: 'select',
                                    options: [
                                        { value: '0', name: 'Sin radio' },
                                        { value: '4px', name: 'Pequeño' },
                                        { value: '8px', name: 'Medio' },
                                        { value: '16px', name: 'Grande' },
                                        { value: '9999px', name: 'Circular' }
                                    ]
                                },
                                { name: 'border', label: 'Borde' },
                                { name: 'box-shadow', label: 'Sombra' },
                                { 
                                    name: 'opacity', 
                                    label: 'Opacidad',
                                    type: 'slider',
                                    min: 0,
                                    max: 1,
                                    step: 0.1
                                }
                            ]
                        },
                        {
                            name: 'Flex',
                            open: false,
                            properties: [
                                { 
                                    name: 'display', 
                                    label: 'Display',
                                    type: 'select',
                                    options: [
                                        { value: 'block', name: 'Block' },
                                        { value: 'flex', name: 'Flex' },
                                        { value: 'grid', name: 'Grid' },
                                        { value: 'inline', name: 'Inline' },
                                        { value: 'none', name: 'None' }
                                    ]
                                },
                                { 
                                    name: 'flex-direction', 
                                    label: 'Dirección',
                                    type: 'select',
                                    options: [
                                        { value: 'row', name: 'Horizontal' },
                                        { value: 'column', name: 'Vertical' }
                                    ]
                                },
                                { 
                                    name: 'justify-content', 
                                    label: 'Justificar',
                                    type: 'select',
                                    options: [
                                        { value: 'flex-start', name: 'Inicio' },
                                        { value: 'center', name: 'Centro' },
                                        { value: 'flex-end', name: 'Final' },
                                        { value: 'space-between', name: 'Espacio Entre' },
                                        { value: 'space-around', name: 'Espacio Alrededor' }
                                    ]
                                },
                                { 
                                    name: 'align-items', 
                                    label: 'Alinear',
                                    type: 'select',
                                    options: [
                                        { value: 'flex-start', name: 'Inicio' },
                                        { value: 'center', name: 'Centro' },
                                        { value: 'flex-end', name: 'Final' },
                                        { value: 'stretch', name: 'Estirar' }
                                    ]
                                },
                                { name: 'gap', label: 'Espacio' }
                            ]
                        },
                        {
                            name: 'Efectos',
                            open: false,
                            properties: [
                                { 
                                    name: 'transition', 
                                    label: 'Transición',
                                    type: 'select',
                                    options: [
                                        { value: 'none', name: 'Ninguna' },
                                        { value: 'all 0.3s ease', name: 'Suave' },
                                        { value: 'all 0.5s ease-in-out', name: 'Media' },
                                        { value: 'all 0.8s cubic-bezier(.17,.67,.83,.67)', name: 'Compleja' }
                                    ]
                                },
                                { 
                                    name: 'transform', 
                                    label: 'Transformación',
                                    type: 'select',
                                    options: [
                                        { value: 'none', name: 'Ninguna' },
                                        { value: 'scale(1.1)', name: 'Escalar' },
                                        { value: 'rotate(45deg)', name: 'Rotar' },
                                        { value: 'translateY(-10px)', name: 'Mover' }
                                    ]
                                },
                                { 
                                    name: 'filter', 
                                    label: 'Filtro',
                                    type: 'select',
                                    options: [
                                        { value: 'none', name: 'Ninguno' },
                                        { value: 'blur(5px)', name: 'Desenfoque' },
                                        { value: 'brightness(150%)', name: 'Brillo' },
                                        { value: 'grayscale(100%)', name: 'Escala de grises' }
                                    ]
                                }
                            ]
                        }
                    ]
                }
            });

            // Cargar contenido inicial
            let initialContent = @json($post->content);
            
            if (typeof initialContent === 'string') {
                try {
                    initialContent = JSON.parse(initialContent);
                } catch (e) {
                    console.error('Error al parsear el contenido:', e);
                    initialContent = {
                        html: '',
                        css: '',
                        components: [],
                        styles: []
                    };
                }
            }

            if (!initialContent) {
                initialContent = {
                    html: '',
                    css: '',
                    components: [],
                    styles: []
                };
            }

            // Cargar el contenido en el editor
            editor.on('load', () => {
                // Limpiar el estado actual
                editor.DomComponents.clear();
                editor.CssComposer.clear();
                
                if (initialContent.html) {
                    // Cargar componentes HTML
                    editor.setComponents(initialContent.html);
                }
                
                if (initialContent.css) {
                    // Cargar estilos CSS
                    editor.setStyle(initialContent.css);
                }

                // Asegurarse de que los estilos se apliquen correctamente
                editor.getWrapper().set('attributes', { id: 'main-content' });
                
                // Refrescar el editor
                editor.refresh();
                
                // Disparar eventos de actualización
                editor.trigger('change:content');
                editor.trigger('style:update');
            });

            // Manejar guardado
            document.getElementById('btnSave').addEventListener('click', async function() {
                try {
                    // Obtener HTML limpio
                    const htmlContent = editor.getHtml();
                    
                    // Obtener CSS usando el CSS Composer
                    const cssManager = editor.Css;
                    const rules = cssManager.getRules();
                    const cssContent = rules.map(rule => {
                        const selector = rule.selectorsToString();
                        const style = rule.getStyle();
                        const mediaText = rule.get('mediaText');
                        
                        // Formatear propiedades CSS
                        const properties = Object.entries(style)
                            .map(([prop, value]) => `    ${prop}: ${value};`)
                            .join('\n');
                        
                        // Manejar media queries
                        if (mediaText) {
                            return `@media ${mediaText} {\n${selector} {\n${properties}\n}\n}`;
                        }
                        
                        return `${selector} {\n${properties}\n}`;
                    }).join('\n\n');
                    
                    // Crear objeto de contenido limpio
                    const content = {
                        html: htmlContent,
                        css: cssContent,
                        // Obtener componentes serializados
                        components: editor.getComponents().map(component => ({
                            type: component.get('type'),
                            content: component.get('content'),
                            attributes: component.get('attributes'),
                            style: component.getStyle()
                        })),
                        // Obtener estilos serializados
                        styles: rules.map(rule => ({
                            selectors: rule.getSelectors().getFullString(),
                            style: rule.getStyle(),
                            mediaText: rule.get('mediaText')
                        }))
                    };

                    // Enviar al servidor
                    const response = await fetch('{{ route("editor.post.save", ["post" => $post]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ content })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        editor.Commands.run('show-message', {
                            message: 'Cambios guardados correctamente',
                            timeout: 2000
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar los cambios');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    editor.Commands.run('show-message', {
                        message: 'Error al guardar los cambios: ' + error.message,
                        timeout: 3000
                    });
                }
            });

            // Vista previa
            document.getElementById('btnPreview').addEventListener('click', function() {
                const modal = editor.Modal;
                
                // Obtener todos los estilos usando el CSS Composer
                const css = editor.Css;
                const rules = css.getRules();
                let allCss = '';

                // Obtener estilos de las reglas
                if (rules.length) {
                    allCss = rules.map(rule => rule.toCSS()).join('\n');
                }

                // Crear un iframe para la vista previa
                const iframe = document.createElement('iframe');
                iframe.style.cssText = `
                    width: 100%;
                    height: 85vh;
                    border: none;
                    background: white;
                `;

                // Configurar el modal
                modal.setTitle('Vista Previa');
                modal.setContent(iframe);
                modal.open({
                    attributes: {
                        class: 'gjs-preview-modal'
                    }
                });

                // Una vez que el iframe está en el DOM, configurar su contenido
                setTimeout(() => {
                    const iframeDoc = iframe.contentDocument;
                    iframeDoc.open();
                    iframeDoc.write(`
                        <!DOCTYPE html>
                        <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <title>Vista Previa</title>
                            
                            <!-- Cargar estilos de Tailwind -->
                            
                            <!-- Estilos personalizados -->
                            <style>
                                ${allCss}
                                /* Estilos base */
                                body {
                                    margin: 0;
                                    font-family: Inter, sans-serif;
                                    min-height: 100vh;
                                }
                                .gjs-preview-content {
                                    min-height: 100vh;
                                    padding: 1rem;
                                }
                            </style>
                        </head>
                        <body class="antialiased">
                            <div class="gjs-preview-content">
                                ${editor.getHtml()}
                            </div>
                        </body>
                        </html>
                    `);
                    iframeDoc.close();

                    // Copiar los estilos de Tailwind del documento principal
                    const tailwindLinks = document.querySelectorAll('link[href*="app.css"]');
                    tailwindLinks.forEach(link => {
                        const clonedLink = link.cloneNode(true);
                        iframeDoc.head.appendChild(clonedLink);
                    });

                    // Aplicar modo oscuro si está activo
                    if (document.documentElement.classList.contains('dark')) {
                        iframeDoc.documentElement.classList.add('dark');
                        iframeDoc.body.classList.add('dark');
                    }
                }, 100);
            });

            // Agregar estilos para el modal de vista previa
            const previewStyle = document.createElement('style');
            previewStyle.innerHTML = `
                .gjs-preview-modal .gjs-mdl-dialog {
                    max-width: 90% !important;
                    max-height: 90vh !important;
                    width: 90% !important;
                }
                
                .gjs-preview-modal .gjs-mdl-content {
                    padding: 0 !important;
                }
                
                .dark .gjs-preview-modal .gjs-mdl-dialog {
                    background-color: #1f2937;
                }
                
                .dark .gjs-preview-modal .gjs-preview-content {
                    background-color: #111827;
                    color: #f3f4f6;
                }
            `;
            document.head.appendChild(previewStyle);

            // Actualizar el modo oscuro en el iframe del editor
            const updateDarkMode = () => {
                const frame = editor.Canvas.getFrameEl();
                if (frame?.contentDocument?.documentElement) {
                    frame.contentDocument.documentElement.classList.toggle(
                        'dark',
                        document.documentElement.classList.contains('dark')
                    );
                }
            };

            // Observer para el modo oscuro
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.attributeName === 'class') {
                        updateDarkMode();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Aplicar el modo oscuro inicial
            editor.on('canvas:load', updateDarkMode);

            editor.on('component:selected', () => {
                const modal = editor.Modal;
                
                // Evento para el botón de ver código HTML
                editor.Commands.add('html-edit', {
                    run: (editor, sender) => {
                        const component = editor.getSelected();
                        const modal = editor.Modal;
                        
                        modal.setTitle('Editor HTML');
                        
                        const container = document.createElement('div');
                        container.style.height = '400px';
                        container.style.width = '100%';
                        
                        const textarea = document.createElement('textarea');
                        // Si hay un componente seleccionado, mostrar su HTML, si no, mostrar todo el contenido
                        textarea.value = component ? component.toHTML() : editor.getHtml();
                        container.appendChild(textarea);
                        
                        // Configurar CodeMirror
                        const codeMirror = CodeMirror.fromTextArea(textarea, {
                            mode: 'htmlmixed',
                            theme: 'dracula',
                            lineNumbers: true,
                            autoCloseTags: true,
                            autoCloseBrackets: true,
                            styleActiveLine: true,
                            matchBrackets: true,
                            matchTags: {bothTags: true},
                            foldGutter: true,
                            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                            extraKeys: {
                                "Ctrl-Space": "autocomplete",
                                "Ctrl-Q": function(cm) { cm.foldCode(cm.getCursor()); },
                                "Ctrl-/": "toggleComment",
                                "Ctrl-F": "findPersistent"
                            },
                            smartIndent: true,
                            lineWrapping: true,
                            indentUnit: 4,
                            showCursorWhenSelecting: true,
                            viewportMargin: Infinity,
                            hint: CodeMirror.hint.html,
                            hintOptions: {
                                completeSingle: false,
                                closeOnUnfocus: false
                            }
                        });
                        
                        // Botones del modal
                        const buttons = document.createElement('div');
                        buttons.className = 'modal-buttons';
                        
                        const updateBtn = document.createElement('button');
                        updateBtn.innerHTML = 'Actualizar';
                        updateBtn.className = 'editor-btn editor-btn-primary';
                        updateBtn.onclick = () => {
                            const code = codeMirror.getValue();
                            
                            try {
                                if (component) {
                                    // Si hay un componente seleccionado
                                    const parent = component.parent();
                                    const index = component.index();
                                    
                                    // Remover el componente actual
                                    component.remove();
                                    
                                    // Crear y añadir el nuevo componente
                                    const newComponent = editor.DomComponents.addComponent(code, {
                                        at: index,
                                        component: parent
                                    });
                                    
                                    // Seleccionar el nuevo componente
                                    editor.select(newComponent);
                                } else {
                                    // Si estamos editando todo el contenido
                                    editor.DomComponents.clear();
                                    editor.DomComponents.addComponent(code);
                                }
                                
                                // Actualizar el canvas
                                editor.refresh();
                                editor.StorageManager.store();
                                
                                // Cerrar el modal
                                modal.close();
                                
                                editor.Commands.run('show-message', {
                                    message: 'Código actualizado correctamente',
                                    timeout: 2000
                                });
                            } catch (error) {
                                console.error('Error al actualizar el HTML:', error);
                                editor.Commands.run('show-message', {
                                    message: 'Error al actualizar el código. Verifica la sintaxis.',
                                    timeout: 3000
                                });
                            }
                        };
                        
                        const closeBtn = document.createElement('button');
                        closeBtn.innerHTML = 'Cerrar';
                        closeBtn.className = 'editor-btn editor-btn-secondary';
                        closeBtn.onclick = () => modal.close();
                        
                        buttons.appendChild(updateBtn);
                        buttons.appendChild(closeBtn);
                        
                        modal.setContent('');
                        modal.setContent(container);
                        modal.getContentEl().appendChild(buttons);
                        modal.open();
                        
                        // Refrescar CodeMirror después de que el modal esté visible
                        setTimeout(() => codeMirror.refresh(), 0);
                    }
                });

                // Evento para el botón de ver código CSS
                editor.Commands.add('css-edit', {
                    run: (editor, sender) => {
                        const modal = editor.Modal;
                        const container = document.createElement('div');
                        
                        // Obtener las reglas CSS usando el CSS Composer
                        const css = editor.Css;
                        const rules = css.getRules();
                        
                        // Formatear el CSS de manera legible
                        const formattedCss = rules.map(rule => {
                            const selector = rule.selectorsToString();
                            const style = rule.getStyle();
                            const mediaText = rule.get('mediaText');
                            
                            // Formatear las propiedades CSS
                            const properties = Object.entries(style)
                                .map(([prop, value]) => `    ${prop}: ${value};`)
                                .join('\n');
                            
                            // Si hay media query, envolver la regla
                            if (mediaText) {
                                return `@media ${mediaText} {\n${selector} {\n${properties}\n}\n}`;
                            }
                            
                            return `${selector} {\n${properties}\n}`;
                        }).join('\n\n');

                        // Crear el editor CodeMirror
                        const codeEditor = CodeMirror(container, {
                            value: formattedCss,
                            mode: 'css',
                            theme: 'dracula',
                            lineNumbers: true,
                            autoCloseTags: true,
                            autoCloseBrackets: true,
                            matchBrackets: true,
                            lineWrapping: true,
                            foldGutter: true,
                            gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                            extraKeys: {
                                'Ctrl-Space': 'autocomplete',
                                'Ctrl-/': 'toggleComment',
                                'Ctrl-Q': function(cm) {
                                    cm.foldCode(cm.getCursor());
                                }
                            },
                            styleActiveLine: true,
                            tabSize: 4,
                            indentUnit: 4,
                            viewportMargin: Infinity
                        });

                        // Ajustar tamaño del editor cuando se abre el modal
                        setTimeout(() => {
                            codeEditor.refresh();
                        }, 10);

                        // Crear botones del modal
                        const btnContainer = document.createElement('div');
                        btnContainer.className = 'modal-buttons';

                        const btnCancel = document.createElement('button');
                        btnCancel.innerHTML = 'Cancelar';
                        btnCancel.className = 'editor-btn editor-btn-secondary';
                        btnCancel.onclick = () => modal.close();

                        const btnUpdate = document.createElement('button');
                        btnUpdate.innerHTML = 'Actualizar CSS';
                        btnUpdate.className = 'editor-btn editor-btn-primary';
                        btnUpdate.onclick = () => {
                            try {
                                const cssContent = codeEditor.getValue();
                                
                                // Limpiar estilos anteriores
                                css.clear();
                                
                                // Añadir las nuevas reglas CSS
                                css.addRules(cssContent);
                                
                                // Actualizar el canvas
                                editor.refresh();
                                
                                // Cerrar el modal
                                modal.close();
                                
                                // Notificar éxito
                                editor.Commands.run('show-message', {
                                    message: 'CSS actualizado correctamente',
                                    timeout: 2000
                                });
                            } catch (error) {
                                console.error('Error al actualizar CSS:', error);
                                editor.Commands.run('show-message', {
                                    message: 'Error al actualizar CSS: ' + error.message,
                                    timeout: 3000
                                });
                            }
                        };

                        btnContainer.appendChild(btnCancel);
                        btnContainer.appendChild(btnUpdate);
                        container.appendChild(btnContainer);

                        modal.setTitle('Editar CSS');
                        modal.setContent(container);
                        modal.open();
                    }
                });
            });

            // Agregar estilos para los botones del modal
            const style = document.createElement('style');
            style.innerHTML = `
                .modal-buttons {
                    display: flex;
                    justify-content: flex-end;
                    gap: 1rem;
                    padding: 1rem;
                    border-top: 1px solid #374151;
                }

                .CodeMirror {
                    height: 400px !important;
                    font-size: 14px;
                }

                .gjs-mdl-dialog {
                    max-width: 900px !important;
                }
            `;
            document.head.appendChild(style);

            editor.Panels.addPanel({
                id: 'code-panel',
                visible: true,
                buttons: [
                    {
                        id: 'edit-html',
                        className: 'editor-btn editor-btn-secondary',
                        label: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>',
                        command: 'html-edit',
                        attributes: { title: 'Editar HTML' }
                    },
                    {
                        id: 'edit-css',
                        className: 'editor-btn editor-btn-secondary',
                        label: '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>',
                        command: 'css-edit',
                        attributes: { title: 'Editar CSS' }
                    }
                ]
            });

            // Agregar comandos personalizados
            const commands = editor.Commands;
            
            // Comando para mostrar mensajes
            commands.add('show-message', {
                run(editor, sender, options = {}) {
                    const msg = document.createElement('div');
                    msg.className = 'gjs-message';
                    msg.style.cssText = `
                        position: fixed;
                        top: 80px;
                        left: 50%;
                        transform: translateX(-50%);
                        padding: 10px 20px;
                        border-radius: 5px;
                        background: #4a5568;
                        color: white;
                        font-size: 14px;
                        z-index: 10000;
                        transition: opacity 0.3s;
                    `;
                    msg.textContent = options.message;
                    document.body.appendChild(msg);

                    setTimeout(() => {
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 300);
                    }, options.timeout || 2000);
                }
            });
            
            // Comando para editar CSS
            commands.add('css-edit', {
                run(editor, sender) {
                    const modal = editor.Modal;
                    const container = document.createElement('div');
                    
                    // Obtener las reglas CSS usando el CSS Composer
                    const css = editor.Css;
                    const rules = css.getRules();
                    
                    // Formatear el CSS de manera legible
                    const formattedCss = rules.map(rule => {
                        const selector = rule.selectorsToString();
                        const style = rule.getStyle();
                        const mediaText = rule.get('mediaText');
                        
                        // Formatear las propiedades CSS
                        const properties = Object.entries(style)
                            .map(([prop, value]) => `    ${prop}: ${value};`)
                            .join('\n');
                        
                        // Si hay media query, envolver la regla
                        if (mediaText) {
                            return `@media ${mediaText} {\n${selector} {\n${properties}\n}\n}`;
                        }
                        
                        return `${selector} {\n${properties}\n}`;
                    }).join('\n\n');

                    // Crear el editor CodeMirror
                    const codeEditor = CodeMirror(container, {
                        value: formattedCss,
                        mode: 'css',
                        theme: 'dracula',
                        lineNumbers: true,
                        autoCloseTags: true,
                        autoCloseBrackets: true,
                        matchBrackets: true,
                        lineWrapping: true,
                        foldGutter: true,
                        gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                        extraKeys: {
                            'Ctrl-Space': 'autocomplete',
                            'Ctrl-/': 'toggleComment',
                            'Ctrl-Q': function(cm) {
                                cm.foldCode(cm.getCursor());
                            }
                        },
                        styleActiveLine: true,
                        tabSize: 4,
                        indentUnit: 4,
                        viewportMargin: Infinity
                    });

                    // Ajustar tamaño del editor cuando se abre el modal
                    setTimeout(() => {
                        codeEditor.refresh();
                    }, 10);

                    // Crear botones del modal
                    const btnContainer = document.createElement('div');
                    btnContainer.className = 'modal-buttons';

                    const btnCancel = document.createElement('button');
                    btnCancel.innerHTML = 'Cancelar';
                    btnCancel.className = 'editor-btn editor-btn-secondary';
                    btnCancel.onclick = () => modal.close();

                    const btnUpdate = document.createElement('button');
                    btnUpdate.innerHTML = 'Actualizar CSS';
                    btnUpdate.className = 'editor-btn editor-btn-primary';
                    btnUpdate.onclick = () => {
                        try {
                            const cssContent = codeEditor.getValue();
                            
                            // Limpiar estilos anteriores
                            css.clear();
                            
                            // Añadir las nuevas reglas CSS
                            css.addRules(cssContent);
                            
                            // Actualizar el canvas
                            editor.refresh();
                            
                            // Cerrar el modal
                            modal.close();
                            
                            // Notificar éxito
                            editor.Commands.run('show-message', {
                                message: 'CSS actualizado correctamente',
                                timeout: 2000
                            });
                        } catch (error) {
                            console.error('Error al actualizar CSS:', error);
                            editor.Commands.run('show-message', {
                                message: 'Error al actualizar CSS: ' + error.message,
                                timeout: 3000
                            });
                        }
                    };

                    btnContainer.appendChild(btnCancel);
                    btnContainer.appendChild(btnUpdate);
                    container.appendChild(btnContainer);

                    modal.setTitle('Editar CSS');
                    modal.setContent(container);
                    modal.open();
                }
            });
        });
    </script>
</body>
</html>
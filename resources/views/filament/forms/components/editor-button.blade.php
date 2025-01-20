@php
    $record = $getRecord();
@endphp

@if($record)
    <div class="flex items-center justify-center py-4">
        <a 
            href="{{ route('editor.post.edit', ['post' => $record]) }}" 
            target="_blank"
            class="fi-btn fi-btn-size-md inline-flex items-center justify-center gap-1 font-semibold rounded-lg bg-primary-600 px-4 py-2 text-white shadow-sm hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:bg-primary-500 dark:hover:bg-primary-400 dark:focus:ring-offset-0 fi-ac-btn-action"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span>Abrir Editor Visual</span>
        </a>
    </div>

    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
        Haga clic en el botón para abrir el editor visual en una nueva pestaña. Los cambios se guardarán automáticamente.
    </div>
@else
    <div class="text-sm text-gray-600 dark:text-gray-400">
        El editor visual estará disponible después de guardar el post.
    </div>
@endif 
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onUnmounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});

const showingNavigationDropdown = ref(false);

const parsedContent = computed(() => {
    if (!props.post.content) {
        return {
            html: '<p class="text-gray-500 italic">No hay contenido disponible</p>',
            css: ''
        }
    }

    try {
        const content = typeof props.post.content === 'string' 
            ? JSON.parse(props.post.content) 
            : props.post.content;
        
        if (typeof window !== 'undefined') {
            const styleId = `post-style-${props.post.id}`;
            let styleElement = document.getElementById(styleId);
            
            if (styleElement) {
                styleElement.remove();
            }
            
            if (content?.css) {
                styleElement = document.createElement('style');
                styleElement.id = styleId;
                styleElement.textContent = `
                    /* Estilos globales del post */
                    ${content.css}
                `;
                document.head.appendChild(styleElement);
            }
        }

        let html = content?.html || '<p class="text-gray-500 italic">No hay contenido disponible</p>';
        
        const postId = `post-content-${props.post.id}`;
        html = `<div id="${postId}" class="post-content">${html}</div>`;
        
        return {
            html,
            css: content?.css || ''
        };
    } catch (error) {
        console.error('Error al parsear el contenido:', error);
        return {
            html: '<p class="text-red-600">Error al cargar el contenido</p>',
            css: ''
        };
    }
});

onUnmounted(() => {
    if (typeof window !== 'undefined' && props.post?.id) {
        const styleElement = document.getElementById(`post-style-${props.post.id}`);
        if (styleElement) {
            styleElement.remove();
        }
    }
});
</script>

<template>
    <Head :title="post.title" />

    <div class="min-h-screen">
        <!-- Navegación -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo y Navegación Izquierda -->
                    <div class="flex">
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('home')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </Link>
                        </div>
                    </div>

                    <!-- Navegación Derecha -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <template v-if="auth.user">
                            <!-- Enlaces para usuarios autenticados -->
                            <Link
                                :href="route('dashboard')"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Dashboard
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Cerrar Sesión
                            </Link>
                        </template>
                        <template v-else>
                            <!-- Enlaces para invitados -->
                            <Link
                                :href="route('login')"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Iniciar Sesión
                            </Link>
                            <Link
                                :href="route('register')"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Registrarse
                            </Link>
                        </template>
                    </div>

                    <!-- Menú Móvil -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menú Móvil Responsive -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <template v-if="auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium transition duration-150 ease-in-out"
                            :class="route().current('dashboard') ? 'border-red-400 text-red-700 bg-red-50 focus:outline-none focus:text-red-800 focus:bg-red-100 focus:border-red-700' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300'"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                        >
                            Cerrar Sesión
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                        >
                            Iniciar Sesión
                        </Link>
                        <Link
                            :href="route('register')"
                            class="block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition duration-150 ease-in-out"
                        >
                            Registrarse
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Contenido del Post -->
        <article class="w-full min-h-screen dark:bg-gray-900">
            <div class="w-screen mx-auto">
                <div 
                    v-html="parsedContent.html"
                ></div>
            </div>
        </article>
    </div>
</template>

<style>
/* Estilos base para el contenido */
.prose {
    max-width: none;
    color: #1a1a1a;
}

.dark .prose {
    color: #e5e7eb;
}

/* Estilos para imágenes */
.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 2rem auto;
    display: block;
}

/* Estilos para enlaces */
.prose a {
    color: #ef4444;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: all 0.2s;
}

.prose a:hover {
    color: #dc2626;
    border-bottom-color: currentColor;
}

.dark .prose a {
    color: #f87171;
}

.dark .prose a:hover {
    color: #ef4444;
}

/* Estilos para citas */
.prose blockquote {
    border-left: 4px solid #ef4444;
    margin: 2rem 0;
    padding: 1rem 0 1rem 2rem;
    font-style: italic;
    color: #991b1b;
    background: transparent;
}

.dark .prose blockquote {
    color: #fca5a5;
}

/* Estilos para títulos */
.prose h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 3rem 0 1.5rem;
    line-height: 1.2;
    color: #111827;
}

.dark .prose h1 {
    color: #f3f4f6;
}

.prose h2 {
    font-size: 2rem;
    font-weight: 700;
    margin: 2.5rem 0 1.25rem;
    line-height: 1.3;
    color: #1f2937;
}

.dark .prose h2 {
    color: #e5e7eb;
}

.prose h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 2rem 0 1rem;
    line-height: 1.4;
    color: #374151;
}

.dark .prose h3 {
    color: #d1d5db;
}

/* Estilos para párrafos */
.prose p {
    margin: 1.5rem 0;
    line-height: 1.8;
    font-size: 1.125rem;
}

/* Estilos para listas */
.prose ul,
.prose ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.prose li {
    margin: 0.5rem 0;
    line-height: 1.6;
}

/* Transiciones suaves */
.prose * {
    transition: color 0.2s ease-in-out, background-color 0.2s ease-in-out;
}
</style> 
<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    posts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Inicio" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Navegación -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            Mi Blog
                        </Link>
                    </div>
                    
                    <div class="flex items-center" v-if="canLogin">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Iniciar Sesión
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2"
                            >
                                Registrarse
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-red-600 to-red-800 dark:from-gray-800 dark:to-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Bienvenido a Mi Blog
                </h1>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Descubre artículos interesantes sobre tecnología, desarrollo web y las últimas tendencias en programación.
                </p>
                <div class="flex justify-center gap-4">
                    <Link
                        href="#latest-posts"
                        class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
                    >
                        Ver Posts
                    </Link>
                    <Link
                        :href="route('register')"
                        v-if="canRegister"
                        class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white/10 transition-colors"
                    >
                        Únete a Nosotros
                    </Link>
                </div>
            </div>
        </div>

        <main class="py-16">
            <!-- Últimos Posts -->
            <div id="latest-posts" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">
                    Últimos Posts
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <article 
                        v-for="post in posts" 
                        :key="post.id" 
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-xl"
                    >
                        <Link :href="route('posts.show', post.slug)">
                            <div class="relative aspect-[16/9] overflow-hidden">
                                <img 
                                    v-if="post.featured_image" 
                                    :src="post.featured_image" 
                                    :alt="post.title"
                                    class="absolute inset-0 w-full h-full object-cover transform hover:scale-110 transition-transform duration-500"
                                >
                                <div 
                                    v-else 
                                    class="absolute inset-0 bg-gradient-to-br from-red-500 to-red-600 dark:from-gray-700 dark:to-gray-800"
                                >
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-white text-4xl opacity-30">
                                            📝
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <time 
                                        :datetime="post.published_at"
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ new Date(post.published_at).toLocaleDateString('es-ES', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        }) }}
                                    </time>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    {{ post.title }}
                                </h3>

                                <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                    {{ post.excerpt }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            Por {{ post.author?.name }}
                                        </span>
                                    </div>
                                    <span class="inline-flex items-center text-red-600 dark:text-red-400 font-medium hover:text-red-700 dark:hover:text-red-300">
                                        Leer más
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </article>
                </div>

                <div v-if="posts.length === 0" class="text-center py-12">
                    <div class="text-gray-600 dark:text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <p class="text-lg">No hay posts publicados aún.</p>
                        <p class="mt-2">¡Vuelve pronto para ver nuevo contenido!</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center text-gray-600 dark:text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} Mi Blog. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
.aspect-[16/9] {
    aspect-ratio: 16/9;
}

@media (prefers-color-scheme: dark) {
    .dark\:from-gray-800 {
        --tw-gradient-from: #1f2937;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgb(31 41 55 / 0));
    }
    .dark\:to-gray-900 {
        --tw-gradient-to: #111827;
    }
}
</style>

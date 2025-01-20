<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PostEditorController extends Controller
{
    public function edit(Post $post)
    {
        // Verificar permisos
        if (!Auth::user()->can('update', $post)) {
            abort(403);
        }

        // Asegurarse de que content sea un array válido
        $post->content = $post->content ?? [
            'html' => '',
            'css' => '',
            'components' => [],
            'styles' => []
        ];

        return view('editor.post', compact('post'));
    }

    public function save(Request $request, Post $post)
    {
        // Verificar permisos
        if (!Auth::user()->can('update', $post)) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        try {
            // Validar el contenido
            $validated = $request->validate([
                'content' => ['required', 'array'],
                'content.html' => ['nullable', 'string'],
                'content.css' => ['nullable', 'string'],
                'content.js' => ['nullable', 'string'],
                'content.components' => ['nullable', 'array'],
                'content.styles' => ['nullable'],
                'content.assets' => ['nullable', 'array']
            ]);

            // Procesar y limpiar el CSS
            $css = isset($validated['content']['css']) ? $validated['content']['css'] : '';
            $styles = $validated['content']['styles'] ?? [];
            
            // Si hay estilos globales, agregarlos al CSS
            if (isset($styles['global']) && is_string($styles['global'])) {
                $css = $styles['global'] . "\n\n" . $css;
            }
            
            // Asegurarse de que todos los campos existan y el CSS esté limpio
            $content = [
                'html' => $validated['content']['html'] ?? '',
                'css' => $css,
                'js' => $validated['content']['js'] ?? '',
                'components' => $validated['content']['components'] ?? [],
                'styles' => $styles,
                'assets' => $validated['content']['assets'] ?? []
            ];

            // Guardar el contenido
            $post->content = $content;
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Contenido guardado correctamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar el contenido del post:', [
                'error' => $e->getMessage(),
                'post_id' => $post->id,
                'content' => $request->input('content')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el contenido: ' . $e->getMessage()
            ], 500);
        }
    }
} 
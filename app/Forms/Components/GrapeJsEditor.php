<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class GrapeJsEditor extends Field
{
    protected string $view = 'forms.components.grape-js-editor';

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state) {
            if (empty($state)) {
                return [
                    'html' => '',
                    'css' => '',
                    'js' => '',
                    'components' => [],
                    'styles' => [],
                    'assets' => []
                ];
            }

            if (is_string($state)) {
                try {
                    return json_decode($state, true) ?: [
                        'html' => $state,
                        'css' => '',
                        'js' => '',
                        'components' => [],
                        'styles' => [],
                        'assets' => []
                    ];
                } catch (\Exception $e) {
                    return [
                        'html' => $state,
                        'css' => '',
                        'js' => '',
                        'components' => [],
                        'styles' => [],
                        'assets' => []
                    ];
                }
            }

            return $state;
        });

        $this->afterStateHydrated(function ($state) {
            if (empty($state)) {
                $this->state([
                    'html' => '',
                    'css' => '',
                    'js' => '',
                    'components' => [],
                    'styles' => [],
                    'assets' => []
                ]);
                return;
            }

            if (is_string($state)) {
                try {
                    $decodedState = json_decode($state, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->state($decodedState);
                        return;
                    }
                } catch (\Exception $e) {
                    // Continuar con el manejo por defecto
                }
            }

            if (!is_array($state)) {
                $this->state([
                    'html' => (string)$state,
                    'css' => '',
                    'js' => '',
                    'components' => [],
                    'styles' => [],
                    'assets' => []
                ]);
            }
        });
    }
} 
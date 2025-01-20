<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;

class GrapeJsContent implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return json_encode([
                'html' => '',
                'css' => '',
                'components' => '[]',
                'styles' => '[]'
            ]);
        }

        if (!Str::isJson($value)) {
            return json_encode([
                'html' => (string)$value,
                'css' => '',
                'components' => '[]',
                'styles' => '[]'
            ]);
        }

        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return json_encode([
                'html' => '',
                'css' => '',
                'components' => '[]',
                'styles' => '[]'
            ]);
        }

        if (is_array($value)) {
            return json_encode($value);
        }

        if (!Str::isJson($value)) {
            return json_encode([
                'html' => (string)$value,
                'css' => '',
                'components' => '[]',
                'styles' => '[]'
            ]);
        }

        return $value;
    }
} 
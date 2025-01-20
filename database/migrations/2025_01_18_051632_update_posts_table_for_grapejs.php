<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convertir el contenido existente al nuevo formato JSON
        DB::table('posts')
            ->whereNotNull('content')
            ->update([
                'content' => DB::raw("JSON_OBJECT(
                    'html', content,
                    'css', '',
                    'components', '[]',
                    'styles', '[]'
                )")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el contenido al formato anterior
        DB::table('posts')
            ->whereNotNull('content')
            ->update([
                'content' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(content, '$.html'))")
            ]);
    }
};

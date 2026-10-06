<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $translations = [
            'Core Language' => 'اللغة الأساسية',
            'Primary Framework' => 'الإطار الأساسي',
            'Version Control' => 'إدارة الإصدارات',
            'API Testing & Docs' => 'اختبار وتوثيق APIs',
            'Local Development' => 'تطوير محلي',
            'IDE' => 'بيئة التطوير',
        ];

        foreach (DB::table('skills')->whereIn('level', array_keys($translations))->get(['id', 'level', 'translations']) as $skill) {
            $content = json_decode($skill->translations ?: '{}', true) ?: [];
            $content['ar']['level'] = $translations[$skill->level];

            DB::table('skills')->where('id', $skill->id)->update([
                'translations' => json_encode($content, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $levels = [
            'Core Language',
            'Primary Framework',
            'Version Control',
            'API Testing & Docs',
            'Local Development',
            'IDE',
        ];

        foreach (DB::table('skills')->whereIn('level', $levels)->get(['id', 'translations']) as $skill) {
            $content = json_decode($skill->translations ?: '{}', true) ?: [];

            if (isset($content['ar']['level'])) {
                unset($content['ar']['level']);
            }

            DB::table('skills')->where('id', $skill->id)->update([
                'translations' => json_encode($content, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
};

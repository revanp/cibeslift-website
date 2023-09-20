<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TranslationCategory;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationCreate extends Command
{
    protected $signature = 'translation:create';

    protected $description = 'Create key and value of translation';

    public function handle()
    {
        $categories = TranslationCategory::select('id', 'name')
            ->get()
            ->toArray();

        $idCategories = array_column($categories, 'id');

        $this->line('');

        $this->info('Category list');

        $this->table(['ID', 'Name'], $categories);

        $this->line('');

        $idTranslationCategory = $this->choice(
            'Choose category ID',
            $idCategories,
            null,
            $maxAttempts = 1,
            $allowMultipleSelections = false
        );

        $selectedCategory = TranslationCategory::find($idTranslationCategory);

        $categoryName     = strtolower(str_replace(' ', '_', $selectedCategory->name));

        $key              = $this->ask('Insert Key Translation');
        $key              = strtolower(str_replace(' ', '_', $key));

        $issetKey = TranslationKey::where([
                'id_translation_category' => $idTranslationCategory,
                'value'                   => $key
            ])
            ->get()
            ->first();

        if(!empty($issetKey)) {
            $this->error("Key \"{$key}\" is already exist");

            return 0;
        }

        try {
            DB::beginTransaction();

            $insKey = [
                'id_translation_category' => $idTranslationCategory,
                'value'                   => $key
            ];

            $transKey = new TranslationKey();

            $transKey->fill($insKey)->save();

            $idTranslationKey = $transKey->id;

            $this->info("ID Key: {$idTranslationKey}");

            $this->line('');

            $value = $this->ask('Insert Translation Value in English');

            $language = [
                'id', 'en'
            ];

            $countLanguage = count($language);
            $errCount    = 0;

            $bar         = $this->output->createProgressBar($countLanguage);
            $bar->start();

            foreach($language as $val){
                $trans = GoogleTranslate::trans($value, $val, 'en');

                $insVal = [
                    'id_translation_key' => $idTranslationKey,
                    'language_code'      => $val,
                    'value'              => $trans,
                    'created_by'         => 1,
                    'updated_by'         => 1
                ];

                $transVal = new TranslationValue();

                $transVal->fill($insVal)->save();
            }

            $bar->advance();

            DB::commit();

            $bar->finish();

            $this->line('');
            $this->line('');

            $this->info("use \"langLocale('{$categoryName}.{$key}')\" for translate content.");

            return 0;
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $err   = $e->errorInfo;

            $this->error($err[2]);

            return 0;
        }
    }
}

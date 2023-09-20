<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\TranslationCategory;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Support\Facades\Storage;

class TranslationPublish extends Command
{
    protected $signature = 'translation:publish';

    protected $description = 'Publish translations';

    public function handle()
    {
        $language = [
            'id', 'en'
        ];

        $countLanguage = count($language);

        $bar = $this->output->createProgressBar($countLanguage);

        $bar->start();

        foreach($language as $val){
            $translation = TranslationCategory::select('id', 'file_name')
                ->with([
                    'translationKey',
                    'translationKey.translationValue' => function($query) use ($val){
                        $query->where('language_code', $val);
                    }
                ])->whereHas('translationKey.translationValue', function($query) use ($val){
                    $query->where('language_code', $val);
                })
                ->get()
                ->toArray();

            if (!empty($translation)) {
                $data = [];

                foreach ($translation as $file) {
                    $filename = "$file[file_name].php";

                    foreach($file['translation_key'] as $key){
                        $key_value = $key['value'];

                        foreach ($key['translation_value'] as $val) {
                            $data[$filename]["$val[language_code]"][$key_value] = $val['value'];
                        }
                    }
                }

                if(!empty($data)) {
                    foreach ($data as $filename => $paths) {
                        foreach ($paths as $path => $values) {
                            $document = "<?php \n\n";

                            $document .= "return [ \n";

                            foreach ($values as $key => $value) {
                                $value    = preg_replace("/'/i", "\'", $value);
                                // $value    = preg_replace("/\"/i", '\"', $value);
                                $document .= "'$key' => '$value', \n";
                            }

                            $document .= "];";

                            Storage::disk('translations')->put("$path/$filename", $document);
                        }
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();

        $this->line('');

        $this->line('');

        $this->info('Translation has been published successfully');
    }
}

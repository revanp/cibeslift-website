<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TranslationCategory;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $datas = [
            0 => [
                'name' => 'Title',
                'file_name' => 'title',
            ],
            1 => [
                'name' => 'Buttons',
                'file_name' => 'buttons'
            ],
            2 => [
                'name' => 'Labels',
                'file_name' => 'labels'
            ],
            3 => [
                'name' => 'Static Content',
                'file_name' => 'static_content'
            ],
            4 => [
                'name' => 'Notifications',
                'file_name' => 'notification'
            ],
        ];

        foreach($datas as $key => $val){
            TranslationCategory::create([
                'name' => $val['name'],
                'file_name' => $val['file_name']
            ]);
        }
    }
}

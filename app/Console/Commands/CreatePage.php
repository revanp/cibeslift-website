<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\PageId;
use Illuminate\Support\Facades\DB;
use Exception;

class CreatePage extends Command
{
    protected $signature = 'make:page';

    protected $description = 'Command to assign a new page into DB';

    public function handle()
    {
        $slug = $this->ask('Insert Slug (NULL for home)');

        $pageIdCheck = PageId::where('slug', $slug)->first();

        if(!empty($pageIdCheck)){
            $this->error("Slug \"{$slug}\" is already exist");

            return 0;
        }

        $en_menu = $this->ask('Insert English menu name');
        $id_menu = $this->ask('Insert Indonesia menu name');

        $this->line("Slug: {$slug}");
        $this->line("English menu name: {$en_menu}");
        $this->line("Indonesia menu name: {$id_menu}");

        $confirmation = $this->ask('Are you sure data is correct? (y/n)');

        if($confirmation == 'n'){
            return 0;
        }else{
            try{
                DB::beginTransaction();

                $pageId = new PageId();

                $pageId->fill([
                    'slug' => $slug,
                    'is_active' => true,
                ])->save();

                $idPageId = $pageId->id;

                $enPage = new Page();
                $enPage->fill([
                    'id_page_id' => $idPageId,
                    'name' => $en_menu,
                    'language_code' => 'en'
                ])->save();

                $idPage = new Page();
                $idPage->fill([
                    'id_page_id' => $idPageId,
                    'name' => $id_menu,
                    'language_code' => 'id'
                ])->save();

                DB::commit();

                $this->info("Menu with slug '".$slug."' is successfully created.");

                return 0;
            }catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();

                $err   = $e->errorInfo;

                $this->error($err[2]);

                return 0;
            }
        }
    }
}

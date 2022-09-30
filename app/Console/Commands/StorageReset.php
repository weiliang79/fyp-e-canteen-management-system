<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class StorageReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all the images in the storage/app/public/photos folder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Clearing storage location: ' . getcwd() . '\storage\app\public\photos');
        StorageReset::delete(getcwd() . '\storage\app\public\photos', false);
        $this->info('The storage was cleared.');
        return 0;
    }

    function Delete($path, bool $deleteRoot)
    {
        if (is_dir($path) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($files as $file) {
                if (in_array($file->getBasename(), array('.', '..')) !== true) {
                    if ($file->isDir() === true) {
                        rmdir($file->getPathName());
                    } else if (($file->isFile() === true) || ($file->isLink() === true)) {
                        unlink($file->getPathname());
                    }
                }
            }

            if($deleteRoot){
                return rmdir($path);
            } else {
                return true;
            }
            
        } else if ((is_file($path) === true) || (is_link($path) === true)) {
            return unlink($path);
        }

        return false;
    }
}

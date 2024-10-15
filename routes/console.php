<?php

use App\Models\BackupHistories;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('backup:run-and-store-path', function () {
    Artisan::call('backup:run --only-db');

    $backupDir = storage_path('app/Laravel');

    $latestBackupPath = collect(File::files($backupDir))
        ->sortByDesc(function ($file) {
            return $file->getCTime();
        })
        ->first();

    if ($latestBackupPath) {
        $fullPath = $latestBackupPath->getPathname();
        $relativePath = str_replace(storage_path() . DIRECTORY_SEPARATOR, '', $fullPath);
        $filename = basename($relativePath);

        BackupHistories::create(['file_name' => $filename]);
        $this->info("Backup file stored at: " . $fullPath);
    } else {
        $this->error("No backup file found.");
    }
});

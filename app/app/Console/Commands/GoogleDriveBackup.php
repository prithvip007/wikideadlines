<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GoogleDriveBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:google-drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database to Google Drive';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (config('app.database_backup.enabled') === false) {
            $this->error('Google Drive backups are not enabled!');
            return;
        }

        $database = env('DB_DATABASE');
        $password = env('DB_PASSWORD');
        $username = env('DB_USERNAME');
        $host = env('DB_HOST');
        $port = env('DB_PORT');

        $date = now()->toISOString();
        $appName = strtolower(config('app.name'));
        $fileName = "{$appName}_{$database}_{$date}_v2";

        // TODO: fix win paths
        $tempFile =sys_get_temp_dir() . "/$fileName";

        $command = "PGPASSWORD=\"$password\" pg_dump --file \"$tempFile\" --host \"$host\" --port \"$port\" --username \"$username\" --no-password --verbose --format=p --section=pre-data --section=data --section=post-data --inserts --column-inserts \"$database\" 2> /dev/null";

        exec($command);

        if (config('app.database_backup.enabled_v1') === true) {
            \Storage::disk('google_backup_v1')->putFileAs(null, $tempFile, $fileName, ['mimetype' => 'application/sql']);
            $this->info('Google Drive V1 backup uploaded');
        }

        if (config('app.database_backup.enabled_v2') === true) {
            \Storage::disk('google_backup_v2')->putFileAs(null, $tempFile, $fileName, ['mimetype' => 'application/sql']);
            $this->info('Google Drive V2 backup uploaded');
        }

        unlink($tempFile);

        $this->info('Google Drive backup finished');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class BackupApp extends Command
{
    protected $signature = 'app:backup';
    protected $description = 'Create a database dump + storage archive backup (private, 7-day rotation)';

    public function handle(): int
    {
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) {
            mkdir($dir, 0700, true);
        }
        $stamp = now()->format('Ymd-His');
        $cfg = config('database.connections.mysql');

        // mysqldump must exist; fail loudly rather than writing an empty backup.
        $version = Process::run(['mysqldump', '--version']);
        if (!$version->successful()) {
            $this->error('mysqldump binary not found; backup aborted.');
            return 1;
        }

        $dump = "$dir/db-$stamp.sql";
        $r = Process::env(['MYSQL_PWD' => $cfg['password']])->run([
            'mysqldump', '--single-transaction',
            '-h', $cfg['host'], '-P', (string) $cfg['port'],
            '-u', $cfg['username'], $cfg['database'],
        ]);
        if (!$r->successful()) {
            $this->error('mysqldump failed; backup aborted.');
            return 1;
        }
        file_put_contents($dump, $r->output());
        if (filesize($dump) < 1000 || !str_contains($r->output(), 'Dump completed')) {
            unlink($dump);
            $this->error('Database dump looks incomplete; backup aborted.');
            return 1;
        }
        Process::run(['gzip', '-f', $dump]);
        $dumpGz = "$dump.gz";

        // Storage archive: everything under storage/app except the backups
        // themselves and the Livewire temp cache (both must not be archived).
        $tar = "$dir/files-$stamp.tar.gz";
        $t = Process::run([
            'tar', '--exclude=backups', '--exclude=livewire-tmp',
            '-czf', $tar, '-C', storage_path('app'), '.',
        ]);
        if (!$t->successful() || filesize($tar) < 100) {
            $this->error('Storage archive failed; backup aborted.');
            return 1;
        }

        // Rotation: keep the last 7 days of backup files.
        foreach (glob("$dir/*") as $f) {
            if (is_file($f) && filemtime($f) < now()->subDays(7)->timestamp) {
                unlink($f);
            }
        }

        $this->info("Backup complete.");
        $this->line("Database: $dumpGz (" . filesize($dumpGz) . " bytes)");
        $this->line("Files:    $tar (" . filesize($tar) . " bytes)");
        $this->line('Restore: see README "Backup & Restore" — always test a restore into a scratch database first.');

        return 0;
    }
}

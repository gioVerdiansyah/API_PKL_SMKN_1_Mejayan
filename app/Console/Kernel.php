<?php

namespace App\Console;

use App\Models\Absensi;
use App\Models\Jurnal;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $jamTutupAbsen = config('app.jam_tutup_absen', '12:00');
        $jamTutupJurnal = config('app.jam_tutup_jurnal', '22:00');

        $schedule->call(function () {
            $users = \App\Models\User::all();

            foreach ($users as $user) {
                if(!Absensi::where('user_id', $user->id)->whereDate('created_at', today())->exists()){
                    Absensi::create([
                        'user_id' => $user->id,
                        'status' => 3,
                        'datang' => now(),
                    ]);
                }
            }
        })->dailyAt($jamTutupAbsen);

        $schedule->call(function () {
            $users = \App\Models\User::all();

            foreach ($users as $user) {
                $hasAlpha = Absensi::where('user_id', $user->id)->whereDate('created_at', today())->exists();
                if(!Jurnal::where("user_id", $user->id)->whereDate('created_at', today())->exists()){
                    Jurnal::create([
                        'user_id' => $user->id,
                        'status' => '3',
                        'kegiatan' => $hasAlpha ? 'Tidak mengisi Jurnal karena Alpha' : 'Tidak mengisi Jurnal'
                    ]);
                }
            }
        })->dailyAt($jamTutupJurnal);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

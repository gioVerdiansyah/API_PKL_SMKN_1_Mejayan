<?php

namespace App\Console;

use App\Models\Absensi;
use App\Models\Jurnal;
use App\Models\Kelompok;
use App\Models\User;
use Carbon\Carbon;
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
            $kelompok = Kelompok::with(['anggota:id,kelompok_id,user_id'])->select('id')->get();

            foreach ($kelompok as $klmpk) {
                foreach ($klmpk->anggota as $anggota) {
                    $user = User::where('id', $anggota->user_id)->first();
                    if ($user->{strtolower(Carbon::now()->dayName)} != null && !Absensi::where('user_id', $user->id)->whereDate('created_at', today())->exists()) {
                        Absensi::create([
                            'user_id' => $user->id,
                            'status' => 3,
                            'datang' => now(),
                        ]);
                    }
                }
            }
        })->dailyAt($jamTutupAbsen);

        $schedule->call(function () {
            $kelompok = Kelompok::with(['anggota:id,kelompok_id,user_id'])->select('id')->get();

            foreach ($kelompok as $klmpk) {
                foreach ($klmpk->anggota as $anggota) {
                    $user = User::where('id', $anggota->user_id)->first();
                    if ($user->{strtolower(Carbon::now()->dayName)} != null && !Jurnal::where("user_id", $user->id)->whereDate('created_at', today())->exists()) {
                        $hasAlpha = Absensi::where('user_id', $user->id)->where('status', '3')->whereDate('created_at', today())->exists();
                        $hasIzin = Absensi::where('user_id', $user->id)->where('status', '6')->whereDate('created_at', today())->exists();
                        $isHoliday = Absensi::where('user_id', $user->id)->where('status', '7')->whereDate('created_at', today())->exists();

                        $kegiatan = "";

                        if ($hasIzin) {
                            $kegiatan = "Tidak ada jurnal karena izin";
                        } else if ($hasAlpha) {
                            $kegiatan = "Tidak ada Jurnal karena Alpha";
                        } else if ($isHoliday) {
                            $kegiatan = "Tidak ada Jurnal karena Libur";
                        } else {
                            $kegiatan = "Tidak ada Jurnal";
                        }

                        Jurnal::create([
                            'user_id' => $user->id,
                            'status' => $hasIzin ? '4' : '3',
                            'kegiatan' => $kegiatan
                        ]);
                    }
                }
            }
        })->dailyAt($jamTutupJurnal);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

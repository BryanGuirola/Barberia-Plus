<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cita;
use Carbon\Carbon;

class MarcarCitasOlvidadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citas:marcar-olvidadas';

    /**
     * The console command description.
     *
     * @var string
     */
   protected $description = 'Marca como olvidadas todas las citas pasadas que sigan en estado pendiente o confirmada';


    /**
     * Execute the console command.
     */
    public function handle()
    {
         $hoy = Carbon::now()->toDateString();

        $citas = Cita::whereIn('estado', ['pendiente', 'confirmada'])
            ->whereDate('fecha', '<', $hoy)
            ->update(['estado' => 'olvidada']);

        $this->info("Citas marcadas como olvidadas: {$citas}");
    }
}

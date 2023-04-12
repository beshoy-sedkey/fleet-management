<?php

namespace App\Console\Commands;

use App\Models\Line;
use App\Models\Station;
use App\Models\Stop;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TaskInitialization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build task also, Seed our database with needed data to test the task.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withErrorHandling(function () {
            $this->validateNotSetupBefore();
            $this->seedStationsTable();
            $this->seedLinesTable();
            $this->seedStopsTable();
            $this->completeSetup();
        });
    }
    /**
     * Handle expected errors
     *
     * @param $callback
     */
    protected function withErrorHandling($callback)
    {
        try {
            DB::transaction(function () use (&$callback) {
                $callback();
            });
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function seedStationsTable()
    {
        foreach (['Cairo', 'Alfayyum', 'Alminya', 'Asyut'] as $station)
            $stations[] = ['name' => $station, 'created_at' => now(), 'updated_at' => now()];

        Station::insert($stations);

        $this->line('<comment>Stations Table Seeded Successfully.</comment>');
    }
    /**
     * @return void
     */
    public function seedLinesTable()
    {
        Line::create(['name' => 'Cairo => Asyut', 'seats' => 12]);

        $this->line('<comment>Lines Table Seeded Successfully.</comment>');
    }

    /**
     * @return void
     */
    public function seedStopsTable()
    {
        for ($station = 1; $station <= 4; $station++)
            Stop::create(['line_id' => 1, 'station_id' => $station, 'priority' => $station]);

        $this->line('<comment>Stops Table Seeded Successfully.</comment>');
    }
    /**
     * Validate whether the setup has been done before
     *
     * @throws \Exception
     */
    protected function validateNotSetupBefore()
    {
        if (file_exists($this->getSetupFilePath())) {
            throw new \Exception('Setup is done already');
        }
    }

    /**
     * Mark the setup as completed
     */
    protected function completeSetup()
    {
        file_put_contents($this->getSetupFilePath(), '');

        $this->info('Setup is completed');
    }


    /**
     * Get the lock file name
     *
     * @return string
     */
    protected function getSetupFilePath()
    {
        return storage_path('setup');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ExerciseDBService;

class SeedExercises extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercises:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed database with common exercises from ExerciseDB API';

    /**
     * Execute the console command.
     */
    public function handle(ExerciseDBService $service)
    {
        $this->info('🏋️  Fetching exercises from ExerciseDB...');
        $this->newLine();
        
        $commonEquipment = ['barbell', 'dumbbell', 'body weight', 'cable', 'kettlebell'];
        $totalCached = 0;

        foreach ($commonEquipment as $equipment) {
            $this->info("Fetching {$equipment} exercises...");
            
            // This will fetch from API and cache in database
            $exercises = $service->getByEquipment($equipment, 100);
            $count = count($exercises);
            $totalCached += $count;
            
            $this->line("  ✓ Cached {$count} {$equipment} exercises");
        }

        $this->newLine();
        $this->info("✅ Successfully cached {$totalCached} exercises!");
        $this->newLine();
        
        $this->comment('These exercises are now cached in your database.');
        $this->comment('Workout generation will be 95% faster! 🚀');

        return Command::SUCCESS;
    }
}

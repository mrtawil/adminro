<?php

namespace Adminro\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DummySeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Exception;

class RefreshTablesWithDummy extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'migrate:freshWithDummy';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Refresh tables and seed dummy data';

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
   * @return int
   */
  public function handle()
  {
    try {
      Artisan::call('migrate:fresh', [
        '--force' => true,
      ]);

      Artisan::call('db:seed', [
        '--class' => DatabaseSeeder::class,
        '--force' => true,
      ]);

      Artisan::call('db:seed', [
        '--class' => DummySeeder::class,
        '--force' => true,
      ]);

      Artisan::call('optimize:clear');
      $this->line('<fg=green>Tables are refreshed and dummy data seeded successfully.');
    } catch (Exception $e) {
      $this->error('Tables refresh and dummy data seed failed.');
      $this->error('Error: ' . $e->getMessage());
    }
  }
}

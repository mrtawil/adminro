<?php

namespace Adminro\Console\Commands;

use Database\Seeders\PermissionSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Exception;

class RefreshPermissions extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'permission:refresh';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Refresh static permissions';

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
      $roles = Role::all();
      $permissions_static = Permission::where('type', 'static')->get();
      foreach ($roles as $role) {
        if (!$role->permission_ids) {
          continue;
        }

        $role->permission_ids = array_diff($role->permission_ids, $permissions_static->pluck('id')->toArray());
        $role->save();
      }
      Permission::where('type', 'static')->delete();
      Artisan::call('db:seed', [
        '--class' => PermissionSeeder::class,
        '--force' => true,
      ]);
      Artisan::call('optimize:clear');
      $this->line('<fg=green>Permssions refreshed successfully.');
    } catch (Exception $e) {
      $this->error('Permssions refresh failed.');
      $this->error('Error: ' . $e->getMessage());
    }
  }
}

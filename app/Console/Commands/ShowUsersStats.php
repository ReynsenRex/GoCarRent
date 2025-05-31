<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class ShowUsersStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show user statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalUsers = User::count();
        $this->info("Total Users: {$totalUsers}");
        
        $roles = Role::withCount('users')->get();
        
        $this->info("\nUsers by Role:");
        foreach ($roles as $role) {
            $this->line("- {$role->name}: {$role->users_count}");
        }
        
        $this->info("\nLatest 5 Users:");
        $latestUsers = User::with('role')->latest()->limit(5)->get();
        
        foreach ($latestUsers as $user) {
            $roleName = $user->role ? $user->role->name : 'No Role';
            $this->line("- {$user->name} ({$user->email}) - {$roleName} - {$user->created_at->format('Y-m-d H:i')}");
        }
    }
}

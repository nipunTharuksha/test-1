<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Artisan::call('migrate:fresh', ['--seed' => true]);
        $this->info(Artisan::output());

        Artisan::call('passport:install');
        $this->info(Artisan::output());

        $this->info('Project initialized successfully');
        $admin = User::whereUserRole('admin')->first();
        $this->table(['user_name', 'email', 'password'], [[$admin->user_name, $admin->email, 'password']]);

    }
}

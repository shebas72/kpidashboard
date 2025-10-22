<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-test {email=test@example.com} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with known credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        
        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->info("User with email {$email} already exists.");
            return;
        }
        
        $user = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        
        $this->info("Test user created successfully!");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
    }
}

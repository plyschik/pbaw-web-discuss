<?php

namespace App\Console\Commands;

use App\User;
use App\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class WebDiscussSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webdiscuss:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup WebDiscuss application.';

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
     * @return mixed
     */
    public function handle()
    {
        if (Schema::hasTable('migrations')) {
            $this->error('This command should be executed only once, but you can rerun this command.');

            if (!$this->confirm('Do you wish to rerun this command?')) {
                return;
            }
        }

        $this->line('');
        $this->line('--------------------');
        $this->line('|                  |');
        $this->line('| WebDiscuss setup |');
        $this->line('|                  |');
        $this->line('--------------------');
        $this->line('');

        $this->line('Database schema creating...');

        $this->callSilent('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        $this->line('');
        $this->info('Database schema created.');

        $this->line('');
        $this->line('Create new administrator account:');

        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now()
        ])->assignRole('administrator');

        $this->line('');
        $this->info('Administrator account created.');

        $category = Category::create([
            'name' => 'Test category'
        ]);

        $category->users()->attach($user);

        $forum = $category->forums()->create([
            'name' => 'Test forum',
            'description' => 'Test forum description.',
        ]);

        $topic = $forum->topics()->create([
            'user_id' => $user->id,
            'title' => 'Test topic'
        ]);

        $topic->replies()->create([
            'user_id' => $user->id,
            'content' => 'Test reply.',
            'is_topic' => 1
        ]);

        $this->callSilent('webdiscuss:stats');

        $this->line('');
        $this->info('Installation complete!');
    }
}
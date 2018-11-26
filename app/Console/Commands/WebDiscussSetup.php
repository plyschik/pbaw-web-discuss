<?php

namespace App\Console\Commands;

use App\User;
use App\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WebDiscussSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webdiscuss:setup {--refresh}';

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
        if (User::count() > 0) {
            $this->error('This command should be executed only once, but you can rerun this command.');

            if (!$this->confirm('Do you wish to rerun this command?')) {
                return;
            }
        }

        $this->callSilent('migrate:fresh', [
            '--force' => true,
            '--seed' => true
        ]);

        $this->line('');
        $this->line('--------------------');
        $this->line('|                  |');
        $this->line('| WebDiscuss setup |');
        $this->line('|                  |');
        $this->line('--------------------');
        $this->line('');

        $this->info('Create new administrator account');

        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $user = User::create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'email_verified_at' => now()
        ])->assignRole('administrator');

        $category = Category::create([
            'name' => 'Test category'
        ]);

        $category->users()->attach($user);

        $channel = $category->channels()->create([
            'name' => 'Test channel',
            'description' => 'Test channel description.',
        ]);

        $topic = $channel->topics()->create([
            'user_id' => $user->id,
            'title' => 'Test topic'
        ]);

        $topic->replies()->create([
            'user_id' => $user->id,
            'content' => 'Test reply.',
            'is_topic' => 1
        ]);

        $this->info('Installation complete!');
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        // Create connection
        $mysql = new \mysqli(env("DB_HOST"), env("DB_USERNAME"), env("DB_PASSWORD"));

        // Check connection
        if($mysql->connect_error) {
            $this->error("Connection failed: " . $mysql->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE " . env("DB_DATABASE");

        if($mysql->query($sql) === TRUE) {
            $this->info("Create Database: " . env("DB_DATABASE"));
            $this->info("Database created successfully");
            \Artisan::call('migrate');
            \Artisan::call('db:seed');
        } else {
            $this->info("Error creating database: " . $mysql->error);
        }

        $mysql->close();
    }
}

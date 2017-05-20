<?php

namespace App\Console\Commands;

use App\User;

use Illuminate\Console\Command;

class EachInsertSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:sub {--m=} {--t=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert Sub title';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();
        
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->option('m');
        $text = $this->option('t');
        
        //or shell_exec
        //exec('cd /vagrant/movie/testmovie;');
        //exec('cd /vagrant/movie/testmovie && ffmpeg -i sp.MOV -vf ass=sub1.ass -strict -2 abcde.mp4 -y', $out, $status);
        
        $file = 'sub1.ass';
        $cont = file_get_contents($file);
        $cont = rtrim($cont, "\n");
        $cont .= $text;

        file_put_contents('/vagrant/cute/storage/app/public/contribute/1.ass', $cont);
        
        //$this->info($status);
        //exec('echo ' . $path . '/' . $text);
        
    }
}

<?php

namespace Mamikos\Tikus\Console;

use Illuminate\Console\Command;
use Mamikos\Tikus\Tikus;
use Exception;

class PingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tikus:ping {message=ping} {--as-exception}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping to the remote systems registered in Tikus';

    public function handle()
    {
        $message = $this->argument('message');
        if (empty($message) === true)
        {
            $this->error('message cannot be blank!');
            return 1;
        }

        $asException = $this->option('as-exception');
        $tikus = new Tikus();

        if ($asException === true)
        {
            $tikus->reportException(new Exception($message));
            $this->info('An exception has been sent!');
        }
        else
        {
            $tikus->reportError('Ping', $message);
            $this->info('A message has been sent!');
        }
    }
}

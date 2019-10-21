<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CustomClass\ToyRobotSimulator;

class StartSimulator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'toy-robot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the toy robot simulator';

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
    public function handle(ToyRobotSimulator $trs)
    {
        $this->printHelpMessage();

        while (true) {
            $command = $this->ask('What is your command?');

            if (!$this->isValidCommand($command)) {
                $this->error("Command `$command` is not valid.");
            }
        }

        $trs->report();
    }

    /**
     * Check requested command is valid.
     *
     * @param string $command
     * @return boolean
     */
    protected function isValidCommand($command)
    {
        return array_key_exists($command, $this->commandMap());
    }

    /**
     * Mapping of valid commands to the class methods.
     *
     * @return array
     */
    protected function commandMap()
    {
        return [
                'P' => 'place',
                'M' => 'move',
                'L' => 'left',
                'R' => 'right',
                'P' => 'report',
        ];
    }

    /**
     * Print help message.
     */
    protected function printHelpMessage()
    {
        $message = "Commands are:\n\n" .
                   "PLACE: P x,y,f\n" .
                   "MOVE: M\n" .
                   "LEFT: L\n" .
                   "RIGHT: R\n" .
                   "REPORT: P\n";

        print($message);
    }
}

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

            if (preg_match('/^PLACE /', $command)) {
                if (!$placeValues = $this->getPlaceValues($command)) {
                    $this->error("Place command `$command` is not valid. It should be eg. P 1,3,N");
                } else {
                    if (!$trs->place((int)$placeValues[0], (int)$placeValues[1], $placeValues[2])) {
                        $this->error($trs->getError());
                    }
                }
            } elseif (!$this->isValidCommand($command)) {
                $this->error("Command `$command` is not valid.");
            } elseif ($command == 'REPORT') {
                $report = $trs->report();
                $this->line($report);
            } else {
                $method = $this->getCommandMap()[$command];
                if (!$trs->$method()) {
                    $this->error($trs->getError());
                }
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
        return array_key_exists($command, $this->getCommandMap());
    }

    /**
     * Get PLACE values to pass to method. If values are valid then return false.
     *
     * @param string $command
     * @return mixed array|boolean
     */
    protected function getPlaceValues($command)
    {
        $command = str_replace('PLACE ', '', $command);
        $values = explode(',', $command);

        if (count($values) != 3) {
            return false;
        }

        if (is_numeric($values[0]) && is_numeric($values[1]) && in_array($values[2], ['N','S','E','W'])) {
            return [$values[0], $values[1], $values[2]];
        }

        return false;
    }

    /**
     * Mapping of valid commands to the class methods.
     *
     * @return array
     */
    protected function getCommandMap()
    {
        return [
                'PLACE' => 'place',
                'MOVE' => 'move',
                'LEFT' => 'left',
                'RIGHT' => 'right',
                'REPORT' => 'report',
        ];
    }

    /**
     * Print help message.
     */
    protected function printHelpMessage()
    {
        $message = "Commands are:\n\n" .
                   "PLACE x,y,f\n" .
                   "MOVE\n" .
                   "LEFT\n" .
                   "RIGHT\n" .
                   "REPORT\n";

        print($message);
    }

    /**
     * Log output to file.
     *
     * @param mixed $msg
     */
    public function logger($msg)
    {
        file_put_contents('/tmp/app.log', date('Y-m-d H:i:s') ." | $msg\n", FILE_APPEND);
    }
}

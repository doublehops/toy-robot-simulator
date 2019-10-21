<?php
namespace App\CustomClass;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ToyRobotSimulator
{
    const X_MIN = 0;
    const X_MAX = 4;
    const Y_MIN = 0;
    const Y_MAX = 4;

    protected $current_x;
    protected $current_y;
    protected $current_f;

    protected $onBoard = false;

    /**
     * Place robot onto board.
     *
     * @param int $x
     * @param int $y
     * @param int $f
     *
     * @return boolean
     */
    public function place(int $x, int $y, string $f)
    {
        if ($this->isOnBoard()) {
            return 'Robot has already been placed on the board.';
        }

        if (!$this->isWithinValidRange($x, $y)) {
            return 'Selection is not within valid range.';
        }

        $this->current_x = $x;
        $this->current_y = $y;
        $this->current_f = $f;

        $this->onBoard = true;
    }

    /**
     * Move robot.
     */
    public function move()
    {
        if (!$this->isOnBoard()) {
            return 'The robot has not yet been placed on the board.';
        }

        $x = $this->current_x;
        $y = $this->current_y;

        switch ($this->current_f) {
            case 'N':
                $y++;
            case 'S':
                $y--;
            case 'E':
                $x++;
            case 'W':
                $x--;
        }

        if (!$this->isWithinValidRange($x, $y)) {
            return 'This move would place the robot in an invalid position.';
        }

        $this->current_x = $x;
        $this->current_y = $y;
    }

    public function report()
    {
        echo "REPORT:\n" .
             "Position X: ". $this->current_x .".\n" .
             "Position Y: ". $this->current_y .".\n" .
             "Facing: ". $this->current_f .".\n";
    }

    /**
     * Determine whether given position is within valid range.
     *
     * @param int $x
     * @param int $y
     * @return boolean
     */
    protected function isWithinValidRange($x, $y)
    {
        return $x >= self::X_MIN &&
               $x <= self::X_MAX &&
               $y >= self::Y_MIN &&
               $y <= self::Y_MAX;
    }

    /**
     * Check if robot has been placed on the board;
     *
     * @return boolean;
     */
    protected function isOnBoard()
    {
        return $this->onBoard;
    }
}

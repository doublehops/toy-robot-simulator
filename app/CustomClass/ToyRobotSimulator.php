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
                break;
            case 'S':
                $y--;
                break;
            case 'E':
                $x++;
                break;
            case 'W':
                $x--;
                break;
        }

        if (!$this->isWithinValidRange($x, $y)) {
            return 'This move would place the robot in an invalid position.';
        }

        $this->current_x = $x;
        $this->current_y = $y;
    }

    /**
     * Point robot one position left.
     */
    public function left()
    {
        $directions = ['N', 'E', 'S', 'W'];

        $key = array_search($this->current_f, $directions);

        if ($key == 0) {
            $this->current_f = $directions[3];
        } else {
            $this->current_f = $directions[$key-1];
        }
    }

    /**
     * Point robot one position right.
     */
    public function right()
    {
        $directions = ['N', 'E', 'S', 'W'];

        $key = array_search($this->current_f, $directions);

        if ($key == 3) {
            $this->current_f = $directions[0];
        } else {
            $this->current_f = $directions[$key+1];
        }
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

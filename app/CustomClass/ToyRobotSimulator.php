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
        if (!$this->isWithinValidRange($x, $y)) {
            return 'Selection is not within valid range.';
        }

        $this->current_x = $x;
        $this->current_y = $y;
        $this->current_f = $f;
    }

    public function report()
    {
        echo "REPORT";
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
}

<?php
/**
 * Class Mars to manage the move of the rovers in mars.
 */
class Mars
{
    /**
     * Map to move.
     *
     * @var array
     */
    private $map    = array();

    /**
     * Current position.
     *
     * @var array
     */
    private $position = array();

    /**
     * Current direction numeric.
     *
     * @var integer
     */
    private $direction;

    /**
     * Map to pass from direction numeric to string.
     *
     * @var array
     */
    private $direction_numeric_to_string = array(
        'N',
        'E',
        'S',
        'W'
    );

    /**
     * The limits of the world.
     *
     * @var array
     */
    private $limits_world = array(
        'x' => 0,
        'y' => 0
    );

    /**
     * For each direction the operation that we should do to update the position.
     *
     * @var array
     */
    private $direction_to_operation = array(
        array( // N --> decrease by 1 the "Y"
            'key'       => 'y',
            'update'    => -1
        ),
        array( // E --> increment by 1 the "X"
            'key'       => 'x',
            'update'    => 1
        ),
        array( // S --> increment by 1 the "Y"
            'key'       => 'y',
            'update'    => 1
        ),array( // W --> decrease by 1 the "X"
            'key'       => 'x',
            'update'    => -1
        )
    );

    /**
     * Init the values.
     *
     * @param array $map The current map.
     * @param array $pos The current position and direction.
     */
    public function __construct( array $map, array $pos )
    {
        $this->map = $map;
        $this->position = array(
            'x' => $pos['x'],
            'y' => $pos['y'],
        );

        $this->limits_world['y'] = count( $map );
        $this->limits_world['x'] = count( $map[0] );

        $this->direction = array_search( $pos['direction'], $this->direction_numeric_to_string );
    }

    /**
     * Move the rover for the map.
     *
     * @param string $commands The commands to move.
     * @return boolean
     */
    public function move( $commands = '' )
    {
        $all_ok   = true;
        $commands = strtolower( $commands );
        if ( $commands )
        {
            $len_commands = strlen( $commands );
            for( $i = 0; $all_ok && $i < $len_commands; ++$i )
            {
                $all_ok = $this->processCommand( $commands[$i] );
            }
        }

        return $all_ok;
    }

    /**
     * Process an individual command.
     *
     * @param string $command The current command to move.
     * @return boolean
     */
    private function processCommand( $command )
    {
        switch ( $command )
        {
            case 'r':
                return $this->updateDirection( 1 );
            case 'l':
                return $this->updateDirection( -1 );
            case 'f':
                return $this->updatePosition( 1 );
            case 'b':
                return $this->updatePosition( -1 );
        }
    }

    /**
     * Update the direction.
     *
     * @param integer $sign_move The sign, right or left.
     * @return boolean
     */
    private function updateDirection( $sign_move )
    {
        $this->direction = ( $this->direction + $sign_move ) % 4;

        if ( $this->direction < 0 )
        {
            $this->direction = 4 + $this->direction;
        }

        return true;
    }

    /**
     * Update the position, if crash return false.
     *
     * @param integer $sign_move The sign of the move, backward or forward.
     * @return boolean
     */
    private function updatePosition( $sign_move )
    {
        $original_pos = $this->position;

        $operation_and_key = $this->direction_to_operation[$this->direction];
        $this->position[$operation_and_key['key']] += ( $operation_and_key['update'] * $sign_move );

        $this->correctOverWorld( $operation_and_key['key'] );

        if ( $this->map[$this->position['y']][$this->position['x']] == '.' )
        {
            return true;
        }

        $this->position = $original_pos;

        return false;
    }

    /**
     * Correct the position if we pass the limits.
     *
     * @param string $key_updated The value update (x or y).
     */
    private function correctOverWorld( $key_updated )
    {
        if ( $this->position[$key_updated] < 0 )
        {
            $this->position[$key_updated] = $this->limits_world[$key_updated] - 1;
        }

        $this->position[$key_updated] = $this->position[$key_updated] % $this->limits_world[$key_updated];
    }

    /**
     * Get the position and direction.
     *
     * @return array
     */
    public function getPosAndDirection()
    {
        return array(
            'x'         => $this->position['x'],
            'y'         => $this->position['y'],
            'direction' => $this->direction_numeric_to_string[$this->direction]
        );
    }
}
?>

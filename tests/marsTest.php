<?php
require_once '../src/MarsRoversKata/mars.php';

class marsTest extends PHPUnit_Framework_TestCase
{
	private $obj;
	
	public function setUp()
	{
        $map = array(
            array( '.', '*' ),
            array( '.', '.' ),
            array( '.', '*' ),
        );

        $orig_pos = array(
            'x' 		=> 0,
            'y' 		=> 0,
            'direction'	=> 'N'
        );

		$this->obj = new Mars( $map, $orig_pos );
	}

    public function moveProvider()
    {
        return array(
            'Test with empty command'   => array(
                'commands'           => '',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'N'
                )
            ),
            'Test turn right only' => array(
                'commands'           => 'R',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'E'
                )
            ),
            'Test turn left only' => array(
                'commands'           => 'L',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'W'
                )
            ),
            'Test turn left and right' => array(
                'commands'           => 'LR',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'N'
                )
            ),
            'Test turn left, right and left in lowercase' => array(
                'commands'           => 'lrl',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'W'
                )
            ),
            'Test position to S and advance one, turn left and advance one'    => array(
                'commands'           => 'RRfLf',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 1,
                    'y' 		=> 1,
                    'direction'	=> 'E'
                )
            ),
            'Test position to S and advance two'    => array(
                'commands'           => 'RRFF',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 2,
                    'direction'	=> 'S'
                )
            ),
            'Test position to S and advance two, Back one, turn right and back one more'    => array(
                'commands'           => 'RRFFBRB',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 1,
                    'y' 		=> 1,
                    'direction'	=> 'W'
                )
            ),
            'Test when crash should return the before cell and false'    => array(
                'commands'           => 'RFLFFR',
                'expected_result'   => false,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'E'
                )
            ),
            'Test when crash should return the before cell and false (when go back)'    => array(
                'commands'           => 'LBLFFR',
                'expected_result'   => false,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'W'
                )
            ),
            'Test when we do the loop by North'  => array(
                'commands'           => 'F',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 2,
                    'direction'	=> 'N'
                )
            ),
            'Test when we do the loop by West'  => array(
                'commands'           => 'BLF',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 1,
                    'y' 		=> 1,
                    'direction'	=> 'W'
                )
            ),
            'Test when we do the loop by South'  => array(
                'commands'           => 'LLFFF',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 0,
                    'direction'	=> 'S'
                )
            ),
            'Test when we do the loop by Est'  => array(
                'commands'           => 'BRFF',
                'expected_result'   => true,
                'expected_position' => array(
                    'x' 		=> 0,
                    'y' 		=> 1,
                    'direction'	=> 'E'
                )
            )
        );
    }

    /**
     * @param $commands
     * @param $expected_result
     * @param $expected_position
     * @dataProvider moveProvider
     */
    public function testMove( $commands, $expected_result, $expected_position )
	{

		$this->assertEquals( $expected_result, $this->obj->move( $commands ), 'If it doesn\'t found any obstacle should return true.' );
		$this->assertEquals( $expected_position, $this->obj->getPosAndDirection(),
            'When we don\'t pass any command, should not move the rover' );
	}

}


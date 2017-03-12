<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 16:14
 */

namespace Building;

use Room\Room;

/**
 * Class Building. Represents a building, a collection of rooms.
 * @package Building
 */
class Building
{

    protected $room;
    protected $desiredTemperature;
    protected $mode;

    /**
     * Building constructor.
     * @param int $desiredTemperature The desired room temperature
     * @param string $mode The output mode, Watts or BTU
     * @param ... Any number of objects from the Room\Room class (or subclasses)
     * @throws \Exception
     */
    public function __construct( int $desiredTemperature, $mode = 'Watts' )
    {
        $this->desiredTemperature   =   $desiredTemperature;
        $this->mode                 =   $mode;
        $this->room                 =   [];

        //Seek out any Room objects passed in as actual arguments
        $numberOfArguments = func_num_args();
        for( $i = 3; $i <= $numberOfArguments; $i++ )
        {
            $actualArgument = func_get_arg( $i-1 );

            if( is_a( $actualArgument, 'Room\Room' ) )
            {
                $this->room[] = $actualArgument;
            }
            else
            {
                throw new \Exception( 'Buildings can only contain rooms' );
            }
        }

    }

    /**
     * @return array Of [room name] = Power required
     * @throws \Exception If there are no rooms
     */
    public function getPowerByRoom() : array
    {
        if( !sizeof( $this->room ) )
        {
            throw new \Exception( 'There are no rooms to calculate' );
        }

        foreach( $this->room as $room )
        {
            $room->setDesiredTemperature( $this->getDesiredTemperature() );
            $room->setMode( $this->getMode() );

            $powerRequired[ $room->getName() ] = round( $room->getPowerToHeat() );
        }

        return $powerRequired;
    }

    /**
     * Get the total power required to heat this house.
     * @return int
     * @throws \Exception
     */
    public function getTotalPower() : int
    {
        if( !sizeof( $this->room ) )
        {
            throw new \Exception( 'There are no rooms to calculate' );
        }

        $powerRequired = 0;

        foreach( $this->room as $room )
        {
            $room->setDesiredTemperature( $this->getDesiredTemperature() );
            $room->setMode( $this->getMode() );

            $powerRequired += round( $room->getPowerToHeat() );
        }

        return $powerRequired;
    }

    /**
     * @return array
     */
    public function getRoom(): array
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room)
    {
        $this->room[] = $room;
    }

    /**
     * @return int
     */
    public function getDesiredTemperature(): int
    {
        return $this->desiredTemperature;
    }

    /**
     * @param int $desiredTemperature
     */
    public function setDesiredTemperature(int $desiredTemperature)
    {
        $this->desiredTemperature = $desiredTemperature;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode(string $mode)
    {
        $this->mode = $mode;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 16:14
 *
 *  MIT License
 *  Copyright (c) 2017 Dane Stevens

 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *   of this software and associated documentation files (the "Software"), to deal
 *   in the Software without restriction, including without limitation the rights
 *   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *   copies of the Software, and to permit persons to whom the Software is
 *   furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in all
 *   copies or substantial portions of the Software.
 *
 *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *   SOFTWARE.
 *
 *
 */

namespace ObjectiveDane\HeatLossCalculator\Building;

use ObjectiveDane\HeatLossCalculator\Room\Room;

/**
 * Class Building. Represents a building, a collection of rooms.
 * @package Building
 */
class Building
{

    protected $room;
    protected $desiredTemperature;
    protected $mode;
    protected $buildingName;

    /**
     * Building constructor.
     * @param int $desiredTemperature The desired room temperature
     * @param string $mode The output mode, Watts or BTU
     * @param ... Any number of objects from the Room\Room class (or subclasses)
     * @throws \Exception
     */
    public function __construct( int $desiredTemperature, $mode = 'Watts', $buildingName = '221b Baker St' )
    {
        $this->desiredTemperature   =   $desiredTemperature;
        $this->mode                 =   $mode;
        $this->room                 =   [];
        $this->buildingName         =   $buildingName;

        //Seek out any Room objects passed in as actual arguments
        $numberOfArguments = func_num_args();
        for( $i = 4; $i <= $numberOfArguments; $i++ )
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
     * @param string $roomName
     * @return Room
     */
    public function getRoom(string $roomName): Room
    {
        return $this->room[$roomName];
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room)
    {
        $this->room[$room->getName()] = $room;
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
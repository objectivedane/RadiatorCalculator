<?php

/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 15:39
 *
 * * MIT License
    Copyright (c) 2017 Dane Stevens

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
 *
 *
 */

namespace ObjectiveDane\HeatLossCalculator\Room;
use ObjectiveDane\HeatLossCalculator\Surface\Surface;

/**
 * Class Room.  A room, in a building, consisting of heat-losing surfaces.
 * @package Room
 */
class Room
{
    //Array of surfaces making this room
    protected $surface;

    //Desired room temperature
    protected $desiredTemperature;

    //Mode of output, BTU or Watts
    protected $mode;

    //Name of room
    protected $name;

    /**
     * Room constructor.
     * @param $name Reference name of room
     * @param ... A number of Surfaces
     * @throws \Exception on invalid argument
     */
    public function __construct($name)
    {
        $this->name     =   $name;
        $this->surface  =   [];

        $numberOfArgs = func_num_args();

        for( $i = 2; $i <= $numberOfArgs; $i++ )
        {
            if( is_a( $actualArgument = func_get_arg( $i-1 ), 'Surface\Surface' ) )
            {
                $this->surface[] = $actualArgument;
            }
            else
            {
                throw new \Exception( 'Rooms can only contain surfaces.' );
            }
        }
    }

    /**
     * Iterate over the surfaces and ask what the power to maintain a temperature is.
     * @return int
     */
    public function getPowerToHeat() : int
    {
        $roomTotal = 0;
        
        foreach( $this->surface as $surface )
        {
             $roomTotal += $surface->getHeatLoss( $this->getDesiredTemperature(), $this->getMode() );
        }

        return $roomTotal;
    }

    /**
     * @return mixed
     */
    public function getDesiredTemperature()
    {
        return $this->desiredTemperature;
    }

    /**
     * @param mixed $desiredTemperature
     */
    public function setDesiredTemperature( $desiredTemperature )
    {
        $this->desiredTemperature = $desiredTemperature;
    }

    /**
     * @return array of Surfaces
     */
    public function getSurface() : array
    {
        return $this->surface;
    }

    /**
     * @param array $surface
     */
    public function setSurface(Surface $surface)
    {
        $this->surface[$surface->getName()] = $surface;
    }


    /**
     * @return mixed
     */
    public function getMode() : string
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode( $mode )
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }


}
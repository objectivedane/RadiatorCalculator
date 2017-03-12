<?php

/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 15:39
 */

namespace Room;

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
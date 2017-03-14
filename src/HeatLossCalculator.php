<?php

/**
 * Created by PhpStorm.
 * User: frank
 * Date: 14/03/17
 * Time: 16:56
 */

namespace ObjectiveDane\HeatLossCalculator;

use ObjectiveDane\HeatLossCalculator\Building\Building;
use ObjectiveDane\HeatLossCalculator\Room\Room;
use ObjectiveDane\HeatLossCalculator\Surface\Surface;

/**
 * Class HeatLossCalculator
 * @package ObjectiveDane\HeatLossCalculator
 */
class HeatLossCalculator
{
    private static $building;

    /**
     * Create the building and provide a name.
     * @param $buildingName
     */
    static public function createBuilding($buildingName)
    {
        self::$building =  new Building(21, 'Watts', $buildingName);
    }

    /**
     * Set the desired temperature for the building
     * @param int $temperature
     */
    static public function setDesiredTemperature(int $temperature)
    {
        self::$building->setDesiredTemperature($temperature);
    }

    /**
     * Set the output mode - BTU or Watts
     * @param $mode
     */
    static public function setMode($mode)
    {
        self::$building->setMode($mode);
    }

    /**
     * Add a room to the building
     * @param string $roomName - give it a name
     * @throws \Exception - if the name is in use
     */
    static public function addRoom(string $roomName)
    {
        if( self::$building->getRoom($roomName) )
        {
            throw new \Exception('Room name already in use.');
        }
        self::$building->setRoom(new Room($roomName));
    }

    /**
     * Fetch a previously created room
     * @param string $roomName
     * @return mixed
     */
    static public function getRoom(string $roomName)
    {
        return self::$building->getRoom($roomName);
    }

    /**
     * Add a surface (wall, ceiling) to the room
     * @param string $roomName
     * @param float $xMeasurement
     * @param float $yMeasurement
     * @param float $uValue
     * @param float $externalTemperature
     * @param string $surfaceName
     * @param ... Any number of child surfaces
     * @throws \Exception on type error on child surfaces
     */
    static public function addSurfaceToRoom(string $roomName, float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemperature, string $surfaceName)
    {
        $surface = new Surface($xMeasurement, $yMeasurement, $uValue, $externalTemperature, $surfaceName);

        //Check for child surfaces
        $numberOfArguments = func_num_args();
        for($i=7; $i <= $numberOfArguments; $i++)
        {
            $actualArgument = func_get_arg($numberOfArguments-1);
            if( is_a( $actualArgument, 'Surface' ) )
            {
                $surface->setChildSurface($actualArgument);
            }
            else
            {
                throw new \Exception('Trying to attach a non-surface to a surface as a child.');
            }
        }

        self::$building->getRoom($roomName)->setSurface($surface);
    }

    /**
     * Create and return a child surface, i.e. window or door
     * @param string $surfaceName
     * @param float $xMeasurement
     * @param float $yMeasurement
     * @param float $uValue
     * @param float $externalTemperature
     * @return Surface
     */
    static public function createChildSurface(string $surfaceName, float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemperature) : Surface
    {
        $surface = new Surface($xMeasurement, $yMeasurement, $uValue, $externalTemperature, $surfaceName);
        return $surface;
    }

    /**
     * Get the heat required to maintain the desired temperature in the entire building
     * @param bool $breakdown - will return an array of power by room
     * @param null $roomName - will return the power for the given room
     * @return mixed
     */
    static public function getHeatRequired($breakdown = false, $roomName = null)
    {
        if( $roomName )
        {
            return self::$building->getRoom($roomName)->getPowerToHeat();
        }
        else if ($breakdown)
        {
            return self::$building->getPowerByRoom();
        }
        else
        {
            return self::$building->getTotalPower();
        }
    }
}
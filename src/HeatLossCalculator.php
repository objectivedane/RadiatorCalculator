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

class HeatLossCalculator
{
    private static $building;

    static public function createBuilding($buildingName)
    {
        self::$building =  new Building(21, 'Watts', $buildingName);
    }

    static public function setDesiredTemperature(int $temperature)
    {
        self::$building->setDesiredTemperature($temperature);
    }

    static public function setMode($mode)
    {
        self::$building->setMode($mode);
    }

    static public function addRoom(string $roomName)
    {
        self::$building->setRoom(new Room($roomName));
    }

    static public function getRoom(string $roomName)
    {
        return self::$building->getRoom($roomName);
    }

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

    static public function createChildSurface(string $surfaceName, float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemperature) : Surface
    {
        $surface = new Surface($xMeasurement, $yMeasurement, $uValue, $externalTemperature, $surfaceName);
        return $surface;
    }

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
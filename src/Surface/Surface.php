<?php
/**
 * Summary.
 *
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 12:44
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

namespace ObjectiveDane\RadiatorCalculator\Surface;

/**
 * Represents a surface which has the ability to conduct heat away from a source.
 * Class Surface
 * @package Surface
 */
class Surface
{
    /**
     * A measurement for calculation of surface area.
     */
    protected $xMeasurement;

    /**
     * A meaasurement for calculation of surface area.
     */
    protected $yMeasurement;

    /**
     * The u Value of the surface material.
     */
    protected $uValue;

    /**
     * Name of surface.
     */
    protected $name;

    /**
     * Array of child surfaces.
     */
    protected $childSurface;

    /**
     * The temperature on the other side of the surface.
     */
    protected $externalTemperature;

    /**
     * Value for conversion of watts to BTU.
     */
    const BTU_MULTIPLIER = 3.412142;

    /**
     * Surface constructor.
     * Name is optional, it is initialised and set to null if not provided.
     * @param float $xMeasurement width
     * @param float $yMeasurement length or height
     * @param float $uValue The U-Value of this surface
     * @param float $externalTemp The cold temperature
     * @param null $name A name for this surface
     */
    public function __construct( float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemp, $name = null )
    {
        $this->setXMeasurement($xMeasurement);
        $this->setYMeasurement($yMeasurement);
        $this->setUValue($uValue);
        $this->externalTemperature      = $externalTemp;
        $this->name                     = $name;
        $this->childSurface             = [];
    }

    /**
     * Provides the power in Watts needed to maintain the desired temperature on one side of this surface.
     * Can take into account one or more child surfaces with different uValues.
     * Performs temperature difference * u Value * suurface area.
     * @param int $desiredTemperature
     * @param string $mode Watts or BTU
     * @return float this is likely one surface of a group, so keep precision
     * @throws \Exception on invalid mode and invalid temperature
     */
    public function getHeatLoss( int $desiredTemperature, $mode = 'Watts' ) : float
    {
        $areaToRemove = 0;
        $heatLossOfChild = 0;

        //Iterate of children removing their surface area from this surface while retaining their heat loss value.
        if( sizeof( $this->getChildSurface() ) )
        {
            foreach( $this->getChildSurface() as $childSurface )
            {
                $areaToRemove       +=  $childSurface->getSurfaceArea();
                $heatLossOfChild    +=  $childSurface->getHeatLoss( $desiredTemperature );
            }
        }

        $temperatureDifference = $desiredTemperature - $this->getExternalTemperature();

        if( $temperatureDifference < 0 ){ throw new \Exception( 'The desired temperature must be more than or equal to the external.' );}

        //Remove any space taken up by child-surfaces
        $surfaceArea = $this->getSurfaceArea() - $areaToRemove;

        //How should the output be represented
        switch($mode)
        {
            case 'Watts':
                return  $temperatureDifference * $surfaceArea * $this->getUValue() + $heatLossOfChild;

            case 'BTU'  :
                return  ( $temperatureDifference * $surfaceArea * $this->getUValue() + $heatLossOfChild ) * $this::BTU_MULTIPLIER;

        }

        throw new \Exception( "$mode was not recognised" );
    }

    /**
     * Returns the area of this surface
     * @return float
     * @throws \Exception on zero area
     */
    public function getSurfaceArea(): float
    {
        if( ( $area = $this->getXMeasurement() * $this->getYMeasurement() ) > 0 )
        {
            return $area;
        }
        else
        {
            throw new \Exception('Surface cannot have zero area');
        }
    }

    /**
     * Getter for $xMeasurement.
     * @return float
     */
    public function getXMeasurement(): float
    {
        return $this->xMeasurement;
    }

    /**
     * Setter for $xMeasurement.
     * @param float $xMeasurement
     * @throws \Exception on non positive float or zero
     */
    public function setXMeasurement( float $xMeasurement )
    {
        if($xMeasurement <= 0)
        {
            throw new \Exception('Measurements must be a positive number');
        }
        $this->xMeasurement = $xMeasurement;
    }

    /**
     * Getter for $yMeasurement.
     * @return float
     */
    public function getYMeasurement(): float
    {
        return $this->yMeasurement;
    }

    /**
     * Setter for $yMeasurement.
     * @param float $yMeasurement
     * @throws \Exception On non positive float
     */
    public function setYMeasurement( float $yMeasurement )
    {
        if($yMeasurement <= 0)
        {
            throw new \Exception('Measurements must be a positive number');
        }

        $this->yMeasurement = $yMeasurement;
    }

    /**
     * Getter for $uValue.
     * @return float
     */
    public function getUValue(): float
    {
        return $this->uValue;
    }

    /**
     * Setter for $uValue.
     * @param float $uValue
     * @throws \Exception on non positive float
     */
    public function setUValue( float $uValue )
    {
        if($uValue <= 0)
        {
            throw new \Exception('A U-Value must be a positive number');
        }
        $this->uValue = $uValue;
    }

    /**
     * Getter for name.
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     * @param null $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * Setter for child surfaces.
     * @param Surface Child surface
     */
    public function setChildSurface( Surface $surfaceToAttach )
    {
        $this->childSurface[] = $surfaceToAttach;
    }

    /**
     * Getter for child surfaces.
     * @return array
     */
    public function getChildSurface() : array
    {
        return $this->childSurface;
    }

    /**
     * Getter for external temperature.
     * @return float
     */
    public function getExternalTemperature(): float
    {
        return $this->externalTemperature;
    }

    /**
     * Setter for external temperature.
     * @param float $externalTemperature
     */
    public function setExternalTemperature( float $externalTemperature )
    {
        $this->externalTemperature = $externalTemperature;
    }



}
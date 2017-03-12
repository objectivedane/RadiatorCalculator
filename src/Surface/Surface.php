<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 12:44
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

namespace Surface;

/**
 * Represents a surface which has the ability to conduct heat away from a source.
 * Class Surface
 * @package Surface
 */
class Surface
{
    // Measurements for area calculation
    protected $xMeasurement;
    protected $yMeasurement;

    //The u Value of the material of construction
    protected $uValue;

    //A name for reference
    protected $name;

    //An array of child surfaces
    protected $childSurface;

    //The temperature on the cold side of this surface
    protected $externalTemperature;

    //The BTU conversion multiplier
    const BTU_MULTIPLIER = 3.412142;

    /**
     * Surface constructor.
     * Name is optional, it is initialised and set to null if not provided.
     * @param float $xMeasurement width
     * @param float $yMeasurement length or height
     * @param float $uValue The U-Value of this surface
     * @param float $externalTemp The cold temperature
     * @param null $name
     */
    public function __construct( float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemp, $name = null )
    {
        $this->xMeasurement             = $xMeasurement;
        $this->yMeasurement             = $yMeasurement;
        $this->uValue                   = $uValue;
        $this->externalTemperature      = $externalTemp;
        $this->name                     = ( $name ) ? $name : null;
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
     * @return float
     */
    public function getXMeasurement(): float
    {
        return $this->xMeasurement;
    }

    /**
     * @param float $xMeasurement
     */
    public function setXMeasurement( float $xMeasurement )
    {
        $this->xMeasurement = $xMeasurement;
    }

    /**
     * @return float
     */
    public function getYMeasurement(): float
    {
        return $this->yMeasurement;
    }

    /**
     * @param float $yMeasurement
     */
    public function setYMeasurement( float $yMeasurement )
    {
        $this->yMeasurement = $yMeasurement;
    }

    /**
     * @return float
     */
    public function getUValue(): float
    {
        return $this->uValue;
    }

    /**
     * @param float $uValue
     */
    public function setUValue( float $uValue )
    {
        $this->uValue = $uValue;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    public function setChildSurface( Surface $surfaceToAttach )
    {
        $this->childSurface[] = $surfaceToAttach;
    }

    /**
     * @return array
     */
    public function getChildSurface() : array
    {
        return $this->childSurface;
    }

    /**
     * @return float
     */
    public function getExternalTemperature(): float
    {
        return $this->externalTemperature;
    }

    /**
     * @param float $externalTemperature
     */
    public function setExternalTemperature( float $externalTemperature )
    {
        $this->externalTemperature = $externalTemperature;
    }



}
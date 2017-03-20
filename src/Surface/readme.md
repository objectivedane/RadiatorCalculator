ObjectiveDane\RadiatorCalculator\Surface\Surface
===============

Represents a surface which has the ability to conduct heat away from a source.

Class Surface


* Class name: Surface
* Namespace: ObjectiveDane\RadiatorCalculator\Surface



Constants
----------


### BTU_MULTIPLIER

    const BTU_MULTIPLIER = 3.412142





Properties
----------


### $xMeasurement

    protected mixed $xMeasurement

A measurement for calculation of surface area.



* Visibility: **protected**


### $yMeasurement

    protected mixed $yMeasurement

A meaasurement for calculation of surface area.



* Visibility: **protected**


### $uValue

    protected mixed $uValue

The u Value of the surface material.



* Visibility: **protected**


### $name

    protected mixed $name

Name of surface.



* Visibility: **protected**


### $childSurface

    protected mixed $childSurface

Array of child surfaces.



* Visibility: **protected**


### $externalTemperature

    protected mixed $externalTemperature

The temperature on the other side of the surface.



* Visibility: **protected**


Methods
-------


### __construct

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::__construct(float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemp, null $name)

Surface constructor.

Name is optional, it is initialised and set to null if not provided.

* Visibility: **public**


#### Arguments
* $xMeasurement **float** - &lt;p&gt;width&lt;/p&gt;
* $yMeasurement **float** - &lt;p&gt;length or height&lt;/p&gt;
* $uValue **float** - &lt;p&gt;The U-Value of this surface&lt;/p&gt;
* $externalTemp **float** - &lt;p&gt;The cold temperature&lt;/p&gt;
* $name **null** - &lt;p&gt;A name for this surface&lt;/p&gt;



### getHeatLoss

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getHeatLoss(integer $desiredTemperature, string $mode)

Provides the power in Watts needed to maintain the desired temperature on one side of this surface.

Can take into account one or more child surfaces with different uValues.
Performs temperature difference * u Value * suurface area.

* Visibility: **public**


#### Arguments
* $desiredTemperature **integer**
* $mode **string** - &lt;p&gt;Watts or BTU&lt;/p&gt;



### getSurfaceArea

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getSurfaceArea()

Returns the area of this surface



* Visibility: **public**




### getXMeasurement

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getXMeasurement()

Getter for $xMeasurement.



* Visibility: **public**




### setXMeasurement

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setXMeasurement(float $xMeasurement)

Setter for $xMeasurement.



* Visibility: **public**


#### Arguments
* $xMeasurement **float**



### getYMeasurement

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getYMeasurement()

Getter for $yMeasurement.



* Visibility: **public**




### setYMeasurement

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setYMeasurement(float $yMeasurement)

Setter for $yMeasurement.



* Visibility: **public**


#### Arguments
* $yMeasurement **float**



### getUValue

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getUValue()

Getter for $uValue.



* Visibility: **public**




### setUValue

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setUValue(float $uValue)

Setter for $uValue.



* Visibility: **public**


#### Arguments
* $uValue **float**



### getName

    string ObjectiveDane\RadiatorCalculator\Surface\Surface::getName()

Getter for name.



* Visibility: **public**




### setName

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setName(null $name)

Setter for name.



* Visibility: **public**


#### Arguments
* $name **null**



### setChildSurface

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setChildSurface(\ObjectiveDane\RadiatorCalculator\Surface\Surface $surfaceToAttach)

Setter for child surfaces.



* Visibility: **public**


#### Arguments
* $surfaceToAttach **[ObjectiveDane\RadiatorCalculator\Surface\Surface](ObjectiveDane-RadiatorCalculator-Surface-Surface.md)** - &lt;p&gt;Child surface&lt;/p&gt;



### getChildSurface

    array ObjectiveDane\RadiatorCalculator\Surface\Surface::getChildSurface()

Getter for child surfaces.



* Visibility: **public**




### getExternalTemperature

    float ObjectiveDane\RadiatorCalculator\Surface\Surface::getExternalTemperature()

Getter for external temperature.



* Visibility: **public**




### setExternalTemperature

    mixed ObjectiveDane\RadiatorCalculator\Surface\Surface::setExternalTemperature(float $externalTemperature)

Setter for external temperature.



* Visibility: **public**


#### Arguments
* $externalTemperature **float**



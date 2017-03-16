ObjectiveDane\HeatLossCalculator\HeatLossCalculator
===============

Class HeatLossCalculator.

This is class uses static methods and acts as an orchestrator for the other classes in the package.
The intention is that the user will only interact with this class.  Start with createBuilding, then addRoom then addSurface to the Rooms.
The radiator size can then be fetched room by room, or as an array of all rooms, or even a building total giving the boiler size requirement (getHeatRequired).


* Class name: HeatLossCalculator
* Namespace: ObjectiveDane\HeatLossCalculator





Properties
----------


### $building

    private mixed $building

The building instance for this calculation.



* Visibility: **private**
* This property is **static**.


Methods
-------


### createBuilding

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createBuilding($buildingName)

Create the building and provide a name.  Rooms can be added to this building.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $buildingName **mixed**



### setDesiredTemperature

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::setDesiredTemperature(integer $temperature)

Set the desired temperature for the building, used by the power requirement formula.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $temperature **integer**



### setMode

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::setMode($mode)

Set the output mode - BTU or Watts. Defaults to Watts.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $mode **mixed** - &lt;ul&gt;
&lt;li&gt;must be BTU or Watts&lt;/li&gt;
&lt;/ul&gt;



### addRoom

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom(string $roomName)

Add a room to the building.  Surfaces are added after.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $roomName **string** - &lt;ul&gt;
&lt;li&gt;give it a name&lt;/li&gt;
&lt;/ul&gt;



### getRoom

    \ObjectiveDane\HeatLossCalculator\Room\Room ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getRoom(string $roomName)

Fetch a previously created room.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $roomName **string**



### addSurfaceToRoom

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom(string $roomName, float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemperature, string $surfaceName)

Add a surface (wall, ceiling) to the room.  Windows and doors can be added as child surfaces by passing them as formal arguments on the end of the argument list.



* Visibility: **public**
* This method is **static**.


#### Arguments
* $roomName **string**
* $xMeasurement **float**
* $yMeasurement **float**
* $uValue **float**
* $externalTemperature **float**
* $surfaceName **string**



### createChildSurface

    \ObjectiveDane\HeatLossCalculator\Surface\Surface ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createChildSurface(string $surfaceName, float $xMeasurement, float $yMeasurement, float $uValue, float $externalTemperature)

Create and return a child surface, i.e. window or door



* Visibility: **public**
* This method is **static**.


#### Arguments
* $surfaceName **string**
* $xMeasurement **float**
* $yMeasurement **float**
* $uValue **float**
* $externalTemperature **float**



### getHeatRequired

    mixed ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getHeatRequired(boolean $breakdown, null $roomName)

Get the heat required to maintain the desired temperature in the entire building



* Visibility: **public**
* This method is **static**.


#### Arguments
* $breakdown **boolean** - &lt;ul&gt;
&lt;li&gt;will return an array of power by room&lt;/li&gt;
&lt;/ul&gt;
* $roomName **null** - &lt;ul&gt;
&lt;li&gt;will return the power for the given room&lt;/li&gt;
&lt;/ul&gt;



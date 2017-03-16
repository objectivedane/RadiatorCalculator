ObjectiveDane\HeatLossCalculator\Building\Building
===============

Class Building. Represents a building, a collection of rooms.




* Class name: Building
* Namespace: ObjectiveDane\HeatLossCalculator\Building





Properties
----------


### $room

    protected mixed $room

An array of Room objects.



* Visibility: **protected**


### $desiredTemperature

    protected mixed $desiredTemperature

The desired temperature for this calculation.



* Visibility: **protected**


### $mode

    protected mixed $mode

Mode of output, either BTU or Watts.



* Visibility: **protected**


### $buildingName

    protected mixed $buildingName

A name for this building.



* Visibility: **protected**


Methods
-------


### __construct

    mixed ObjectiveDane\HeatLossCalculator\Building\Building::__construct(integer $desiredTemperature, string $mode, \ObjectiveDane\HeatLossCalculator\Building\... $buildingName)

Building constructor.



* Visibility: **public**


#### Arguments
* $desiredTemperature **integer** - &lt;p&gt;The desired room temperature&lt;/p&gt;
* $mode **string** - &lt;p&gt;The output mode, Watts or BTU&lt;/p&gt;
* $buildingName **ObjectiveDane\HeatLossCalculator\Building\...** - &lt;p&gt;Any number of objects from the Room\Room class (or subclasses)&lt;/p&gt;



### getPowerByRoom

    array ObjectiveDane\HeatLossCalculator\Building\Building::getPowerByRoom()

Return an array where elements are (string) roomName => (int) powerRequiredToHeatRoom



* Visibility: **public**




### getTotalPower

    integer ObjectiveDane\HeatLossCalculator\Building\Building::getTotalPower()

Get the total power required to heat this house.



* Visibility: **public**




### getRoom

    \ObjectiveDane\HeatLossCalculator\Room\Room ObjectiveDane\HeatLossCalculator\Building\Building::getRoom(string $roomName)

Getter for a Room object in the array.



* Visibility: **public**


#### Arguments
* $roomName **string**



### setRoom

    mixed ObjectiveDane\HeatLossCalculator\Building\Building::setRoom(\ObjectiveDane\HeatLossCalculator\Room\Room $room)

Add a Room object to the array.



* Visibility: **public**


#### Arguments
* $room **[ObjectiveDane\HeatLossCalculator\Room\Room](ObjectiveDane-HeatLossCalculator-Room-Room.md)**



### getDesiredTemperature

    integer ObjectiveDane\HeatLossCalculator\Building\Building::getDesiredTemperature()

Get the desired temperature.



* Visibility: **public**




### setDesiredTemperature

    mixed ObjectiveDane\HeatLossCalculator\Building\Building::setDesiredTemperature(integer $desiredTemperature)

Set the desired temperature.



* Visibility: **public**


#### Arguments
* $desiredTemperature **integer**



### getMode

    string ObjectiveDane\HeatLossCalculator\Building\Building::getMode()

Get the output mode.



* Visibility: **public**




### setMode

    mixed ObjectiveDane\HeatLossCalculator\Building\Building::setMode(string $mode)

Set the output mode.



* Visibility: **public**


#### Arguments
* $mode **string**



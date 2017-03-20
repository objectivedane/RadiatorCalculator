ObjectiveDane\RadiatorCalculator\Room\Room
===============

Class Room.  A room, in a building, consisting of heat-losing surfaces.




* Class name: Room
* Namespace: ObjectiveDane\RadiatorCalculator\Room





Properties
----------


### $surface

    protected mixed $surface

An array of Surface objects



* Visibility: **protected**


### $desiredTemperature

    protected mixed $desiredTemperature

The desired temperature of this room



* Visibility: **protected**


### $mode

    protected mixed $mode

The output mode (Watts or BTU) for this room.



* Visibility: **protected**


### $name

    protected mixed $name

The name of this Room/



* Visibility: **protected**


Methods
-------


### __construct

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::__construct($name)

Room constructor.



* Visibility: **public**


#### Arguments
* $name **mixed** - &lt;p&gt;String reference name of room&lt;/p&gt;



### getPowerToHeat

    integer ObjectiveDane\RadiatorCalculator\Room\Room::getPowerToHeat()

Iterate over the surfaces and ask what the power to maintain a temperature is.



* Visibility: **public**




### getDesiredTemperature

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::getDesiredTemperature()

Getter for desiredTemperature.



* Visibility: **public**




### setDesiredTemperature

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::setDesiredTemperature(mixed $desiredTemperature)

Setter for desiredTemperature.



* Visibility: **public**


#### Arguments
* $desiredTemperature **mixed**



### getSurface

    boolean|mixed ObjectiveDane\RadiatorCalculator\Room\Room::getSurface($surfaceName)

Get a Surface from the array.



* Visibility: **public**


#### Arguments
* $surfaceName **mixed**



### setSurface

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::setSurface(\ObjectiveDane\RadiatorCalculator\Surface\Surface $surface)

Add a Surface to the array.



* Visibility: **public**


#### Arguments
* $surface **[ObjectiveDane\RadiatorCalculator\Surface\Surface](ObjectiveDane-RadiatorCalculator-Surface-Surface.md)**



### getMode

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::getMode()

Get the output mode.



* Visibility: **public**




### setMode

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::setMode(mixed $mode)

Set the output mode.



* Visibility: **public**


#### Arguments
* $mode **mixed**



### getName

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::getName()

Get the Room name.



* Visibility: **public**




### setName

    mixed ObjectiveDane\RadiatorCalculator\Room\Room::setName(mixed $name)

Set the Room name.



* Visibility: **public**


#### Arguments
* $name **mixed**



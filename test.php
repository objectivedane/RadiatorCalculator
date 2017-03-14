<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 13:02
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
 */


/* require_once 'Surface/Surface.php';
require_once 'Room/Room.php';
require_once 'Building/Building.php';

$wall = new \Surface\Surface(3, 2.6, 2.2, 0,  'wall');
$wall2 = new \Surface\Surface(3, 2.6, 1.7, 0, 'wall');
$wall3 = new \Surface\Surface(3.5, 2.6, 1.7, 20, 'wall');
$wall4 = new \Surface\Surface(3, 2.6, 1.7, 18, 'wall');
$floor = new \Surface\Surface(3, 3, 1.7, 15, 'floor');
$ceiling = new \Surface\Surface(3, 3, 1.4, 18, 'ceiling');

$window = new \Surface\Surface(1 , 1.2, 3, 0, 'window');


$wall->setChildSurface($window);

$spare = new \Room\Room('Spare Room', $wall, $wall2, $wall3, $wall4, $floor, $ceiling);
$other = new \Room\Room('Other Room', $wall2, $wall2, $wall2, $wall4, $floor, $ceiling);

$myHouse = new \Building\Building(20, 'BTU', $spare, $other);
var_dump($myHouse->getPowerByRoom(), $myHouse->getTotalPower());

*/
require_once __DIR__ . "/vendor/autoload.php";

\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createBuilding('Dane\'s house');
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom('Lounge');
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Lounge', 3, 3, 1, 5, 'Outer Wall');
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Lounge', 3, 3, 1, 5, 'Inner Wall');
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Lounge', 3, 3, 1, 5, 'Ceiling');

\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom('Diner');
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Diner', 3, 5, 1, 5, 'Outer Wall');
$door = \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createChildSurface('Window', 1.5, 1.5, 2, 5);
$window = \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createChildSurface('Door', 2, 1.5, 2, 5);
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Diner', 3, 5, 1, 5, 'Inner Wall', $door, $window);
\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('Diner', 3, 5, 1, 5, 'Another Wall');


var_dump(\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getHeatRequired(true));


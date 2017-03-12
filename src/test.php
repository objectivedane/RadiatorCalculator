<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 12/03/17
 * Time: 13:02
 */
require_once 'Surface/Surface.php';
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
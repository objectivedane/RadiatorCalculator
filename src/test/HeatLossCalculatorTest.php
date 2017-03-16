<?php

/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16/03/17
 * Time: 10:30
 */

/**
 * Class HeatLossCalculatorTest
 * @covers HeatLossCalculator
 */
final class HeatLossCalculatorTest extends \PHPUnit\Framework\TestCase
{

    private $aChildSurface;

    public function setUp()
    {
        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createBuilding();
        ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom('name here');

        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 5, 'Outer Wall (North)');
        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 7, 'Outer Wall (West)');
        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 7, 'Outer Wall (East)');
        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 18, 'Ceiling');
        \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 10, 'Floor');

        $this->aChildSurface = \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createChildSurface('Window', 1.2, 1.2, 2, 5);

    }

    /**
     * Are we recognising invalid modes.
     * @expectedException Exception
     */
   public function testInvalidMode()
   {
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::setMode('FOO');
   }

    /**
     * @expectedException Exception
     */
   public function testDuplicateRoom()
   {
       ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom('name here');
   }

   /**
    * Does getRoom return a Room, or false on empty?
    */
   public function testGetRoom()
   {
       $this->assertInstanceOf(\ObjectiveDane\HeatLossCalculator\Room\Room::class, \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getRoom('name here'));
       $this->assertFalse(\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getRoom('FooBar'));
   }

    /**
     * @expectedException Exception
     */
   public function testAddSurfaceDuplicate()
   {
       //Duplicate should throw exception
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 5, 'Outer Wall (North)');
   }

    /**
     * @expectedException Exception
     */
   public function testAddNegativeSurface()
   {
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('name here', -2, 34, 1.8, 5, 'test wall');
   }

   /**
    * Test the formula.
    */
   public function testReliability()
   {
       /**
        * area (m2) x temperature difference x U Value
        *
        * 3x 2mx2m walls with 1.8 uValue and 16deg difference
        * (4m2 x 16deg x 1.8uVal = 115.2) x 3 walls
        *
        * 1x 2mx2m wall with 1.8 uValue and 16deg difference with a 1mx1m window at 2.5 u Value
        * Window: 1m2 x 16deg x 2.5uVal = 40
        * (4m2 - 1m2) x 16deg x 1.8uVal = 86.4
        *
        * 345.6 + 40 + 86.4 = 472
        *
        */

       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addRoom('test room');
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall1');
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall2');
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall3');

       $window = \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::createChildSurface('window', 1, 1, 2.5, 5);
       \ObjectiveDane\HeatLossCalculator\HeatLossCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall4', $window);

       $this->assertEquals(\ObjectiveDane\HeatLossCalculator\HeatLossCalculator::getHeatRequired(false, 'test room'), 472);
   }


}
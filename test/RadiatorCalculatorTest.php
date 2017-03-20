<?php

/**
 * Created by PhpStorm.
 * User: frank
 * Date: 16/03/17
 * Time: 10:30
 */

/**
 * Class RadiatorCalculatorTest
 * @covers RadiatorCalculator
 */

use ObjectiveDane\RadiatorCalculator\RadiatorCalculator as RadiatorCalculator;

final class RadiatorCalculatorTest extends \PHPUnit\Framework\TestCase
{

    private $aChildSurface;

    public function setUp()
    {
        RadiatorCalculator::createBuilding();
        RadiatorCalculator::addRoom('name here');

        RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 5, 'Outer Wall (North)');
        RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 7, 'Outer Wall (West)');
        RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 7, 'Outer Wall (East)');
        RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 18, 'Ceiling');
        RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 10, 'Floor');

        $this->aChildSurface = RadiatorCalculator::createChildSurface('Window', 1.2, 1.2, 2, 5);

    }

    /**
     * Are we recognising invalid modes.
     * @expectedException Exception
     */
   public function testInvalidMode()
   {
       RadiatorCalculator::setMode('FOO');
   }

    /**
     * @expectedException Exception
     */
   public function testDuplicateRoom()
   {
       ObjectiveDane\RadiatorCalculator\RadiatorCalculator::addRoom('name here');
   }

   /**
    * Does getRoom return a Room, or false on empty?
    */
   public function testGetRoom()
   {
       $this->assertInstanceOf(\ObjectiveDane\RadiatorCalculator\Room\Room::class, RadiatorCalculator::getRoom('name here'));
       $this->assertFalse(RadiatorCalculator::getRoom('FooBar'));
   }

    /**
     * @expectedException Exception
     */
   public function testAddSurfaceDuplicate()
   {
       //Duplicate should throw exception
       RadiatorCalculator::addSurfaceToRoom('name here',3, 3, 1.8, 5, 'Outer Wall (North)');
   }

    /**
     * @expectedException Exception
     */
   public function testAddNegativeSurface()
   {
       RadiatorCalculator::addSurfaceToRoom('name here', -2, 34, 1.8, 5, 'test wall');
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

       RadiatorCalculator::addRoom('test room');
       RadiatorCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall1');
       RadiatorCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall2');
       RadiatorCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall3');

       $window = RadiatorCalculator::createChildSurface('window', 1, 1, 2.5, 5);
       RadiatorCalculator::addSurfaceToRoom('test room', 2, 2, 1.8, 5, 'wall4', $window);

       $this->assertEquals(RadiatorCalculator::getHeatRequired(false, 'test room'), 472);
   }


}
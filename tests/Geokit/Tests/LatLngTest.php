<?php

/*
 * This file is part of Geokit.
 *
 * (c) Jan Sorgalla <jsorgalla@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Geokit\Tests;

use Geokit\LatLng;

/**
 * @author  Jan Sorgalla <jsorgalla@googlemail.com>
 * @version @package_version@
 *
 * @covers Geokit\LatLng
 */
class LatLngTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorShouldAcceptStringsAsArguments()
    {
        $latLng = new LatLng('1.1234', '2.5678');

        $this->assertSame(1.1234, $latLng->getLatitude());
        $this->assertSame(2.5678, $latLng->getLongitude());
    }

    public function testConstructorShouldAcceptFloatsAsArguments()
    {
        $latLng = new LatLng(1.1234, 2.5678);

        $this->assertSame(1.1234, $latLng->getLatitude());
        $this->assertSame(2.5678, $latLng->getLongitude());
    }

    public function testConstructorShouldAcceptLocalizedFloatsAsArguments()
    {
        $currentLocale = setlocale(LC_NUMERIC, '0');
        setlocale(LC_NUMERIC, 'de_DE.utf8', 'de_DE@euro', 'de_DE', 'deu_deu');

        $latitude  = floatval('1.1234');
        $longitude = floatval('2.5678');

        $latLng = new LatLng($latitude, $longitude);

        $this->assertSame(1.1234, $latLng->getLatitude());
        $this->assertSame(2.5678, $latLng->getLongitude());

        setlocale(LC_NUMERIC, $currentLocale);
    }

    public function testToStringShouldReturnLatitudeAndLongitudeAsCommaSeparatedString()
    {
        $latLng = new LatLng(1.1234, 2.5678);

        $this->assertSame(sprintf('%F,%F', 1.1234, 2.5678), (string) $latLng);
    }

    public function testToStringShouldReturnLatitudeAndLongitudeAsCommaSeparatedStringWithLocalizedFloats()
    {
        $currentLocale = setlocale(LC_NUMERIC, '0');
        setlocale(LC_NUMERIC, 'de_DE.utf8', 'de_DE@euro', 'de_DE', 'deu_deu');

        $latitude  = floatval('1.1234');
        $longitude = floatval('2.5678');

        $latLng = new LatLng($latitude, $longitude);

        $this->assertSame(sprintf('%F,%F', 1.1234, 2.5678), (string) $latLng);
        setlocale(LC_NUMERIC, $currentLocale);
    }

    public function testToGeometryShouldReturnGeometryPointObject()
    {
        $latLng = new LatLng(1.1234, 2.5678);

        $point = $latLng->toGeometry();

        $this->assertInstanceOf('Geokit\Geometry\Point', $point);

        $this->assertSame(1.1234, $point->getY());
        $this->assertSame(2.5678, $point->getX());
    }

    public function testDistanceTo()
    {
        $latLng = new LatLng(44.65105198323727, 60.463472083210945);

        $distance = $latLng->distanceTo(new LatLng(-35.21140778437257, 83.73959356918931));

        $this->assertEquals(sprintf('%F', 9195565.498553), sprintf('%F', $distance));
    }
}
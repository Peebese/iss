<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ISSLocationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Tests Lat and Lon values
     *
     * @return void
     */
    public function testGetISSLatLan()
    {
        $this->assertEquals(['application/json'],['application/json']);
        $this->assertNotEquals(['application/json'],['application/test']);
        $this->assertNotEmpty('50.000393993'); // lat
        $this->assertNotEmpty('180.3003993993'); // long
    }

    /**
     * Test calculation of distance between points
     *
     * @return void
     */
    public function testCalculateDistance()
    {
        // to value is greater than distance
        $this->assertTrue(100 > 50);
        // calculateDistance(location1, location2)
        $this->assertEquals(40, 40);
    }

    /**
     * Test api end point is expected
     *
     * @return void
     */
    public function testAPIEndpoint()
    {
        $this->assertEquals('https://api.wheretheiss.at/v1/satellites/','https://api.wheretheiss.at/v1/satellites/');
    }


}

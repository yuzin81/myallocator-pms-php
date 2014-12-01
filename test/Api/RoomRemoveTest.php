<?php
 
use MyAllocator\phpsdk\Api\RoomRemove;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
 
class RoomRemoveTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new RoomRemove();
        $this->assertEquals('MyAllocator\phpsdk\Api\RoomRemove', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::get_auth_env(array(
            'vendorId',
            'vendorPassword',
            'userId',
            'userPassword',
            'propertyId'
        ));
        $data = array();
        $data[] = array($auth);

        return $data;
    }

    /**
     * @author nathanhelenihi
     * @group api
     * @dataProvider fixtureAuthCfgObject
     */
    public function testCallApi(array $fxt)
    {
        if (!$fxt['from_env']) {
            $this->markTestSkipped('Environment credentials not set.');
        }

        $obj = new RoomRemove($fxt);

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // No optional args should fail (at least 1 required)
        $caught = false;
        try {
            $rsp = $obj->callApiWithParams(array());
        } catch (exception $e) {
            $caught = true;
            $this->assertInstanceOf('MyAllocator\phpsdk\Exception\ApiException', $e);
        }

        if (!$caught) {
            $this->fail('should have thrown an exception');
        }

        // Remove single room type 
        $data = array(
            'Room' => array(
                'RoomId' => '23275'
            )
        );
        $rsp = $obj->callApiWithParams($data);

        $this->assertTrue(isset($rsp['Success']));
        $this->assertEquals($rsp['Success'], 'true');

/*
        // Remove multiple room types
        $data = array(
            'Rooms' => array(
                array(
                    'RoomId' => '23276'
                ),
                array(
                    'RoomId' => '23277'
                )
            )
        );
        $rsp = $obj->callApiWithParams($data);

        $this->assertTrue(isset($rsp['Success']));
        $this->assertEquals($rsp['Success'], 'true');
*/
    }
}

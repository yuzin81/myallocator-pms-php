<?php
 
use MyAllocator\phpsdk\Api\PropertyModify;
use MyAllocator\phpsdk\Object\Auth;
use MyAllocator\phpsdk\Util\Common;
 
class PropertyModifyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new PropertyModify();
        $this->assertEquals('MyAllocator\phpsdk\Api\PropertyModify', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::getAuthEnv(array(
            'vendorId',
            'vendorPassword',
            'userToken',
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

        $obj = new PropertyModify($fxt);

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // Successful call
        $rsp = $obj->callApiWithParams(array(
            'PropertyName' => 'PHP SDK Hotel A',
            'ExpiryDate' => '2015-01-20',
            'Currency' => 'USD',
            'Country' => 'US',
            'Breakfast' => 'EX'
        ));

        $this->assertTrue(isset($rsp['response']['Success']));
        $this->assertEquals($rsp['response']['Success'], 'true');
    }
}
<?php

namespace MyAllocator\phpsdk\tests\xml;
 
use MyAllocator\phpsdk\src\Api\BookingPaymentDownload;
use MyAllocator\phpsdk\src\Object\Auth;
use MyAllocator\phpsdk\src\Util\Common;
use MyAllocator\phpsdk\src\Exception\ApiAuthenticationException;
 
class BookingPaymentDownloadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @author nathanhelenihi
     * @group api
     */
    public function testClass()
    {
        $obj = new BookingPaymentDownload();
        $this->assertEquals('MyAllocator\phpsdk\src\Api\BookingPaymentDownload', get_class($obj));
    }

    public function fixtureAuthCfgObject()
    {
        $auth = Common::getAuthEnv(array(
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

        $obj = new BookingPaymentDownload($fxt);
        $obj->setConfig('dataFormat', 'xml');

        if (!$obj->isEnabled()) {
            $this->markTestSkipped('API is disabled!');
        }

        // Invalid booking id should fail
        $auth = $fxt['auth'];
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <BookingPaymentDownload>
                    <Auth>
                        <VendorId>{$auth->vendorId}</VendorId>
                        <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                        <UserId>{$auth->userId}</UserId>
                        <UserPassword>{$auth->userPassword}</UserPassword>
                        <PropertyId>{$auth->propertyId}</PropertyId>
                    </Auth>
                    <OrderId>99999999999999999</OrderId>
                    <CreditCardPassword>!password1</CreditCardPassword>
                </BookingPaymentDownload>
        ";

        $rsp = $obj->callApiWithParams($xml);
        $this->assertEquals(200, $rsp['code']);
        $this->assertNotFalse(
            strpos($rsp['response'], '<Errors>'),
            'Response contains errors!'
        );

        // Valid order id and valid password should succeed
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <BookingPaymentDownload>
                    <Auth>
                        <VendorId>{$auth->vendorId}</VendorId>
                        <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                        <UserId>{$auth->userId}</UserId>
                        <UserPassword>{$auth->userPassword}</UserPassword>
                        <PropertyId>{$auth->propertyId}</PropertyId>
                    </Auth>
                    <OrderId>4304-63761582-4625</OrderId>
                    <CreditCardPassword>!password1</CreditCardPassword>
                </BookingPaymentDownload>
        ";

        $rsp = $obj->callApiWithParams($xml);
        $this->assertEquals(200, $rsp['code']);
        $this->assertFalse(
            strpos($rsp['response'], '<Errors>'),
            'Response contains errors!'
        );

        // Valid myallocator id and valid password should succeed
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
                <BookingPaymentDownload>
                    <Auth>
                        <VendorId>{$auth->vendorId}</VendorId>
                        <VendorPassword>{$auth->vendorPassword}</VendorPassword>
                        <UserId>{$auth->userId}</UserId>
                        <UserPassword>{$auth->userPassword}</UserPassword>
                        <PropertyId>{$auth->propertyId}</PropertyId>
                    </Auth>
                    <MyAllocatorId>5485e70e399dbd9a2451a744</MyAllocatorId>
                    <CreditCardPassword>!password1</CreditCardPassword>
                </BookingPaymentDownload>
        ";

        $rsp = $obj->callApiWithParams($xml);
        $this->assertEquals(200, $rsp['code']);
        $this->assertFalse(
            strpos($rsp['response'], '<Errors>'),
            'Response contains errors!'
        );
    }
}
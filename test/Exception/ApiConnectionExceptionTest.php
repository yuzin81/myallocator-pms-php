<?php
 
use MyAllocator\phpsdk\Exception\ApiConnectionException;
 
class ApiConnectionExceptionTest extends PHPUnit_Framework_TestCase
{
    private $message = 'message'; 
    private $httpStatus = 'status'; 
    private $httpBody = 'body'; 
    private $jsonBody = 'body'; 

    /**
     * @author nathanhelenihi
     * @group exception
     */
    public function testApiConnectionException()
    {
        try {
            throw new ApiConnectionException(
                $this->message, 
                $this->httpStatus,
                $this->httpBody,
                $this->jsonBody
            );
        } catch (Exception $e) {
            $this->assertInstanceOf('MyAllocator\phpsdk\Exception\ApiConnectionException', $e);
            $this->assertEquals($this->message, $e->getMessage());
            $this->assertEquals($this->httpStatus, $e->getHttpStatus());
            $this->assertEquals($this->httpBody, $e->getHttpBody());
            $this->assertEquals($this->jsonBody, $e->getJsonBody());
        }
    }
}

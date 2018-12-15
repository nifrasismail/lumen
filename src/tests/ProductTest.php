<?php

class ProductTest extends TestCase
{
    /**
     * product entity api test
     *
     * @return void
     */
    public function testProductEntityGetRequests()
    {
        $response = $this->call('GET', '/v1/products');
        $this->assertEquals(200, $response->status());

        $response = $this->call('GET', '/v1/product/0');
        $this->assertEquals(404, $response->status());

        $response = $this->call('GET', '/v1/product/11');
        $this->assertEquals(200, $response->status());
    }
}

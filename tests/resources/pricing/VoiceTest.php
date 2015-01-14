<?php

use \Mockery as m;
require_once 'Twilio.php';

class VoiceTest extends PHPUnit_Framework_TestCase {

    function testGetCountries() {
        $data = array(
            'countries' => array(
                array('iso_country' => 'US')
            )
        );
        $http = m::mock(new Services_Twilio_TinyHttp);
        $http->shouldReceive('get')->once()->with(
            '/v1/Voice/Countries.json?Page=0&PageSize=50'
        )->andReturn(array(200, array('Content-Type' => 'application/json'),
                                 json_encode($data)));

        $pricingClient = new Pricing_Services_Twilio('AC123', '123', 'v1',
                                                     $http, 1);
        $countries = $pricingClient->voiceCountries->getPage();
        $this->assertNotNull($countries);

        $country = $countries->getItems()[0];
        $this->assertNotNull($country);
        $this->assertEquals($country->iso_country, 'US');
    }

    function testGetCountry() {
        $http = m::mock(new Services_Twilio_TinyHttp);
        $http->shouldReceive('get')->once()->with('/v1/Voice/Countries/EE.json')
            ->andReturn(array(200, array('Content-Type' => 'application/json'),
                        json_encode(array('country' => 'Estonia'))));
        $pricingClient = new Pricing_Services_Twilio('AC123', '123', 'v1', $http, 1);

        $country = $pricingClient->voiceCountries->get('EE');
        $this->assertNotNull($country);
        $this->assertEquals($country->iso_country, 'EE');
        $this->assertEquals($country->country, 'Estonia');
    }

    function testGetNumber() {
        $http = m::mock(new Services_Twilio_TinyHttp);
        $http->shouldReceive('get')->once()->with(
            '/v1/Voice/Numbers/+14155551234.json'
        )->andReturn(array(200, array('Content-Type' => 'application/json'),
                             json_encode(array('iso_country' => 'US'))));

        $pricingClient = new Pricing_Services_Twilio('AC123', '123', 'v1', $http, 1);

        $number = $pricingClient->voiceNumbers->get('+14155551234');
        $this->assertNotNull($number);
        $this->assertEquals($number->number, '+14155551234');
        $this->assertEquals($number->iso_country, 'US');
    }

}
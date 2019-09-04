<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Verify\V2\Service;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class VerificationTest extends HolodeckTestCase {
    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                     ->verifications->create("to", "channel");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $values = array('To' => "to", 'Channel' => "channel", );

        $this->assertRequest(new Request(
            'post',
            'https://verify.twilio.com/v2/Services/VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Verifications',
            null,
            $values
        ));
    }

    public function testCreateVerificationResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "sid": "VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "service_sid": "VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "to": "+15017122661",
                "channel": "sms",
                "status": "pending",
                "valid": false,
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "lookup": {
                    "carrier": {
                        "error_code": null,
                        "name": "Carrier Name",
                        "mobile_country_code": "310",
                        "mobile_network_code": "150",
                        "type": "mobile"
                    }
                },
                "amount": null,
                "payee": null,
                "url": "https://verify.twilio.com/v2/Services/VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Verifications/VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            }
            '
        ));

        $actual = $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                           ->verifications->create("to", "channel");

        $this->assertNotNull($actual);
    }

    public function testCreateVerificationWithRateLimitsResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "sid": "VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "service_sid": "VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "to": "+15017122661",
                "channel": "sms",
                "status": "pending",
                "valid": false,
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "lookup": {
                    "carrier": {
                        "error_code": null,
                        "name": "Carrier Name",
                        "mobile_country_code": "310",
                        "mobile_network_code": "150",
                        "type": "mobile"
                    }
                },
                "amount": null,
                "payee": null,
                "url": "https://verify.twilio.com/v2/Services/VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Verifications/VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            }
            '
        ));

        $actual = $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                           ->verifications->create("to", "channel");

        $this->assertNotNull($actual);
    }

    public function testUpdateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                     ->verifications("sid")->update("canceled");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $values = array('Status' => "canceled", );

        $this->assertRequest(new Request(
            'post',
            'https://verify.twilio.com/v2/Services/VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Verifications/sid',
            null,
            $values
        ));
    }

    public function testUpdateVerificationResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "service_sid": "VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "to": "+15017122661",
                "channel": "sms",
                "status": "canceled",
                "valid": false,
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "lookup": {
                    "carrier": {
                        "error_code": null,
                        "name": "Carrier Name",
                        "mobile_country_code": "310",
                        "mobile_network_code": "150",
                        "type": "mobile"
                    }
                },
                "amount": null,
                "payee": null,
                "url": "https://verify.twilio.com/v2/Services/VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Verifications/VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            }
            '
        ));

        $actual = $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                           ->verifications("sid")->update("canceled");

        $this->assertNotNull($actual);
    }

    public function testApproveVerificationWithPnResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "service_sid": "VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "to": "+15017122661",
                "channel": "sms",
                "status": "approved",
                "valid": true,
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "lookup": {
                    "carrier": {
                        "error_code": null,
                        "name": "Carrier Name",
                        "mobile_country_code": "310",
                        "mobile_network_code": "150",
                        "type": "mobile"
                    }
                },
                "amount": null,
                "payee": null,
                "url": "https://verify.twilio.com/v2/Services/VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Verifications/VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            }
            '
        ));

        $actual = $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                           ->verifications("sid")->update("canceled");

        $this->assertNotNull($actual);
    }

    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                     ->verifications("sid")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://verify.twilio.com/v2/Services/VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Verifications/sid'
        ));
    }

    public function testFetchVerificationResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "service_sid": "VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "to": "+15017122661",
                "channel": "sms",
                "status": "pending",
                "valid": false,
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "lookup": {
                    "carrier": {
                        "error_code": null,
                        "name": "Carrier Name",
                        "mobile_country_code": "310",
                        "mobile_network_code": "150",
                        "type": "mobile"
                    }
                },
                "amount": null,
                "payee": null,
                "url": "https://verify.twilio.com/v2/Services/VAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Verifications/VEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            }
            '
        ));

        $actual = $this->twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                           ->verifications("sid")->fetch();

        $this->assertNotNull($actual);
    }
}
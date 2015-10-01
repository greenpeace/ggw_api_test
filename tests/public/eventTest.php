<?php
class eventTest extends GreenwireApiTestCase {

    public function testIndexHeaders() {
        // Arrange
        $r = $this->socket->get(
            '/public/events.json?', [
                "domain" => "usa",
                "limit" => 1
            ]
        );

        // The call should return something
        $this->assertNotEquals($r,false);
        $r = (json_decode($r,true));
        $this->checkBasics($r);

        // check the headers code
        $this->assertEquals($r['header']['code'],'200', 'code should be set to 200');
        $this->assertEquals($r['header']['resources'],'events', 'resource should be set to events');

        // there should be no errors in the headers
        $this->assertTrue(isset($r['header']['pagination']), 'pagination should be set on index');
        $this->assertFalse(($r['header']['pagination'] === 'null'), 'empty pagination should not be equal to the string null');

        // PENDING FIX
        //$this->assertFalse(isset($r['header']['error']), 'error should not be set');
        //$this->assertFalse(($r['header']['error'] === 'null'), 'empty error should not be equal to the string null');
    }

    public function testIndexBody() {
        // Arrange
        $r = $this->socket->get(
            '/public/events.json?', [
                "domain" => "netherlands",
                "limit" => 1
            ]
        );

        // The call should return something
        $this->assertNotEquals($r,false);
        $r = (json_decode($r,true));
        $this->checkBasics($r);

        // check if the content is ok
        $this->assertTrue(isset($r['body']['events'][0]), 'event should be set in the body');
        $e = $r['body']['events'][0];
        $this->assertFalse(empty($e), 'event should not be empty');
        $this->assertTrue(isset($e['uuid']), 'event uuid should not be empty');
        $this->assertTrue(isset($e['serial']), 'event uuid should not be empty');
        $this->assertTrue(isset($e['created']), 'event creation date should not be empty');
        $this->assertTrue(isset($e['modified']), 'event modification should not be empty');
        $this->assertTrue(isset($e['name']), 'event name should not be empty');
        $this->assertTrue(isset($e['start_date']), 'event start date should not be empty');
        $this->assertTrue(isset($e['end_date']), 'event end date should not be empty');
        $this->assertTrue(isset($e['description']), 'event description should not be empty');
        $this->assertTrue(isset($e['picture']), 'event picture should not be empty');
        $this->assertTrue(isset($e['organizers']), 'event organizers should not be empty');
        $this->assertTrue(isset($e['groups']), 'event groups should not be empty');
        $this->assertTrue(isset($e['location']), 'event location should not be empty');
        $this->checkLocation($e['location']);
        $this->assertTrue(isset($e['tags']), 'event tags should not be empty');
        // $this->assertTrue(isset($e['url']), 'URL should not be empty'); // GREEN-3436
    }

}

<?php
/**
 * Greenwire API Test Case
 */
class GreenwireApiTestCase extends PHPUnit_Framework_TestCase
{
    protected $socket = null;

    protected function setUp()
    {
        parent::setUp();
        $this->socket = new ggw_socket();
    }

    protected function checkBasics($r) {

        // the results should have the followings in a header
        $this->assertTrue(isset($r['header']), 'no header set in returned message');
        $this->assertTrue(isset($r['header']['id']), 'no id set in returned message header');
        $this->assertTrue(isset($r['header']['code']), 'no code set in returned message header');
        $this->assertTrue(isset($r['header']['status']), 'no status set in returned message header');
        $this->assertTrue(isset($r['header']['resources']), 'no resource set in returned message header');
    }

    protected function checkLocation($l) {
        $this->assertTrue(isset($l['country']), 'location country should be set');
        $this->assertTrue(isset($l['streetname']), 'location streetname should be set');
        $this->assertTrue(isset($l['postcode']), 'location postcode should be set');
        $this->assertTrue(isset($l['city']), 'location city should be set');
        $this->assertTrue(isset($l['state']), 'location state should be set');
        $this->assertTrue(isset($l['coordinates']), 'location country should be set');
        $this->assertTrue(isset($l['coordinates']['latitude']), 'location latitude should be set');
        $this->assertTrue(isset($l['coordinates']['longitude']), 'location longitude should be set');
    }
}
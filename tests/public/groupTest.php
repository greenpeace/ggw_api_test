<?php
class GroupsTest extends GreenwireApiTestCase {

    public function testViewHeaders() {
        // Arrange
        $r = $this->socket->get(
            '/public/groups/324e1602-3673-4d52-93ee-eadf94cbea67.json', [
                "domain" => "netherlands",
                "limit" => 1
            ]
        );

        // The call should return something
        $this->assertNotEquals($r,false);
        $r = (json_decode($r,true));
        $this->checkBasics($r);

        // check the headers code
        $this->assertEquals($r['header']['code'],'200', 'code should be set to 200');
        $this->assertEquals($r['header']['resources'],'group', 'resource should be set to group');

        // there should be no errors in the headers
        $this->assertFalse(isset($r['header']['pagination']), 'pagination should be empty on view');
        $this->assertFalse(($r['header']['pagination'] === 'null'), 'empty pagination should not be equal to the string null');
        $this->assertFalse(isset($r['header']['error']), 'error should not be set');
        $this->assertFalse(($r['header']['error'] === 'null'), 'empty error should not be equal to the string null');
    }

    public function testViewBody() {
        // Arrange
        $r = $this->socket->get(
            '/public/groups/324e1602-3673-4d52-93ee-eadf94cbea67.json', [
                "domain" => "netherlands",
                "limit" => 1
            ]
        );

        // The call should return something
        $this->assertNotEquals($r,false);
        $r = (json_decode($r,true));
        $this->checkBasics($r);

        // check if the content is ok
        $this->assertTrue(isset($r['body']['group']), 'Group should be set in the body');
        $g = $r['body']['group'];
        $this->assertFalse(empty($g), 'Group should not be empty');
        $this->assertTrue(isset($g['uuid']), 'Group uuid should not be empty');
        $this->assertTrue(isset($g['serial']), 'Group uuid should not be empty');
        $this->assertTrue(isset($g['created']), 'Group creation date should not be empty');
        $this->assertTrue(isset($g['modified']), 'Group modification should not be empty');
        $this->assertTrue(isset($g['name']), 'Group name should not be empty');
        $this->assertTrue(isset($g['mission']), 'Group mission should not be empty');
        $this->assertTrue(isset($g['description']), 'Group description should not be empty');
        $this->assertTrue(isset($g['picture']), 'Group picture should not be empty');
        $this->assertTrue(isset($g['group_type']), 'Group type should not be empty');
        $this->assertTrue(isset($g['location']), 'Group location should not be empty');
        $this->checkLocation($g['location']);
        $this->assertTrue(isset($g['tags']), 'Group tags should not be empty');

    }

}

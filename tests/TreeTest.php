<?php
class TreeTest extends TestCase{

    public function testGetTree()
    {
        $this->get('/tree');
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data'
        ]);
    }
}
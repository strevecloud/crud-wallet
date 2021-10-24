<?php
class SequenceTest extends TestCase{

    public function testGetSquence()
    {
        $this->get('/sequence');
        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'status_code',
            'status_message',
            'data'
        ]);
    }
}
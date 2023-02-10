<?php declare(strict_types=1);

require  __DIR__ . '/../../helpers/helpers.php';

use PHPUnit\Framework\TestCase;
use Models\Work;

class WorkTest extends TestCase
{
    private $model;
    private $db;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->model = new Work();
    }

    public function testSelect()
    {
        $this->db = $this->getMockedPDO();
        $this->model->database = $this->db;

        $query = $this->getMockBuilder('\PDOStatement')->getMock();
        $query->method('fetchAll')->willReturn([]);

        $result = $this->model->select();
        $this->assertIsArray($result);
        $this->assertEquals($result, []);
    }

    public function testInsertSuccess()
    {
        $this->db = $this->getMockedPDO();
        $this->model->database = $this->db;

        $result = $this->model->insert([
            'name' => 'name 1'
        ]);

        $this->assertTrue($result);
    }

    public function testInsertFail()
    {
        $this->db = $this->getMockedPDO(false);
        $this->model->database = $this->db;

        $result = $this->model->insert([
            'name' => 'name 1'
        ]);

        $this->assertNull($result);
    }

    public function testUpdate()
    {
        $this->db = $this->getMockedPDO();
        $this->model->database = $this->db;
        
        $result = $this->model->update([
            'name' => 'name 1'
        ]);

        $this->assertTrue($result);
    }

    public function testDelete()
    {
        $this->db = $this->getMockedPDO();
        $this->model->database = $this->db;
        
        $result = $this->model->delete('id = 1');

        $this->assertTrue($result);
    }

    protected function getMockedPDO($success = true)
    {
        $query = $this->getMockBuilder('\PDOStatement')->getMock();

        if ($success) {
            $query->method('execute')->willReturn(true);
        } else {
            $query->method('execute')->will($this->throwException(new PDOException()));
        }

        $db = $this->getMockBuilder('\PDO')
            ->disableOriginalConstructor()
            ->onlyMethods(['prepare'])
            ->getMock();

        $db->method('prepare')->willReturn($query);

        return $db;
    }
}
<?php declare(strict_types=1);

require  __DIR__ . '/../../helpers/helpers.php';

use PHPUnit\Framework\TestCase;
use Controllers\WorkController;
use Models\Work;

class WorkControllerTest extends TestCase
{
    protected $controller;
    protected $work;

    public function setUp(): void
    {
        parent::setUp();

        //mock the model
        $this->work = $this->getMockBuilder(Work::class)
            ->getMock();

        //mock the controller
        $this->controller = new WorkController();
        $this->controller->work = $this->work;
    }

    public function testIndex(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Work 1',
                'start_date' => '2021-01-01',
                'end_date' => '2021-01-31',
                'status' => 'Planning'
            ]
        ];

        //mock the select method
        $this->work->expects($this->once())
            ->method('select')
            ->willReturn($data);

        // call the index method
        $this->controller->index();
    }

    public function testCreateSuccess(): void
    {
        $_POST = [
            'name' => 'Work 1',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'status' => 'Planning'
        ];

        //mock the insert method
        $this->work->expects($this->once())
            ->method('insert')
            ->willReturn(true);

        // call the create method
        $this->controller->create();

        // assert success and redirect
        $this->assertEquals(302, http_response_code());
    }

    public function testCreateError(): void
    {
        $_POST = [
            'name' => '',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'status' => 'Planning'
        ];

        //mock the insert method
        $this->work->expects($this->never())
            ->method('insert');

        // call the create method
        $this->controller->create();

        // assert validation error
        $this->assertEquals(422, http_response_code());
    }

    public function testUpdateSuccess(): void
    {
        $_POST = [
            'id' => 1,
            'name' => 'Work 1',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'status' => 'Planning'
        ];

        $this->work->expects($this->once())
            ->method('select')
            ->willReturn([$_POST]);

        //mock the update method
        $this->work->expects($this->once())
            ->method('update')
            ->willReturn(true);

        // call the update method
        $this->controller->update();

        // assert the result
        $this->assertEquals(302, http_response_code());
    }

    public function testUpdateError(): void
    {
        // mock return empty data
        $data = $this->work->expects($this->once())
            ->method('select')
            ->willReturn([]);

        //mock the update method
        $this->work->expects($this->never())
            ->method('update');

        // call the update method of controller
        $this->controller->update();

        // assert the result
        $this->assertEquals(404, http_response_code());
    }

    public function testDeleteSuccess(): void
    {
        $_GET = [
            'id' => 1
        ];

        //mock the delete method
        $this->work->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        // call the delete method
        $this->controller->delete();

        // assert the result
        $this->assertEquals(302, http_response_code());
    }
}
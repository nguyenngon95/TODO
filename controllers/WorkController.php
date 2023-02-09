<?php

namespace Controllers;

use Models\Work;

class WorkController
{
    public Work $work;

    public function __construct()
    {
        $this->work = new Work;
    }

    public function index()
    {
        $data = $this->work->select();

        return view('works/index', compact('data'));
    }

    public function add()
    {
        return view('works/add-edit');
    }

    public function create()
    {
        $name = $_POST['name'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $status = $_POST['status'];

        if (!$name || !$startDate || !$endDate || !$status) {
            return view('works/add-edit', ['error' => 'Please fill all fields!']);
        }

        if ($startDate > $endDate) {
            return view('works/add-edit', ['error' => 'Start date must be less than end date!']);
        }
        
        $this->work->insert([
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status
        ]);

        return redirect('');
    }

    public function edit()
    {
        $id = $_GET['id'];
        
        $work = $this->work->select('*', "id = {$id}")[0];

        if (!$work) {
            return view('error', ['error' => '404 Not Found!']);
        }
        
        return view('works/add-edit', compact('work'));
    }

    public function update()
    {
        $id = $_POST['id'];

        $work = $this->work->select('*', "id = {$id}")[0];

        $name = $_POST['name'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $status = $_POST['status'];
        
        if (!$name || !$startDate || !$endDate || !$status) {
            return view('works/add-edit', [
                'error' => 'Please fill all fields!',
                'work' => $work
            ]);
        }

        if ($startDate > $endDate) {
            return view('works/add-edit', [
                'error' => 'Start date must be less than end date!',
                'work' => $work
            ]);
        }

        $this->work->update([
            'name' => $name,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status
        ], "id = {$id}");

        return redirect('edit/' . $id);
    }

    public function delete()
    {
        $id = $_GET['id'];
        
        $this->work->delete("id = {$id}");

        return redirect('');
    }

    public function calendar()
    {
        $data = $this->work->select(
            'name as title, start_date as start, end_date as end'
        );

        // add random color for each work
        foreach ($data as $key => $value) {
            $data[$key]['color'] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        }

        return view('works/calendar', compact('data'));
    }
}
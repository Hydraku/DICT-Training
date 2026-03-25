<?php

namespace App\Controllers;

// use App\Controllers\BaseController;
// use CodeIgniter\model;
use App\Models\TaskModel;


class TaskController extends BaseController
{
    protected $taskModel;


    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }


    public function index()
    {
        $data = [
            'tasks' => $this->taskModel
                ->where('user_id', session()->get('user_id'))
                ->orderBy('created_at', 'DESC')->findAll(),
            'title' => 'All Tasks',
        ];
        return view('tasks/index', $data);
    }


    public function show($id)
    {
        $task = $this->taskModel->find($id);
        if (! $task || $task['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found.');
        }
        return view('tasks/show', ['task' => $task, 'title' => $task['title']]);
    }


    public function create()
    {
        return view('tasks/create', ['title' => 'Create Task']);
    }


    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'status'      => 'required|in_list[pending,in-progress,completed]',
            'due_date'    => 'permit_empty|valid_date',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $this->taskModel->save([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
            'due_date'    => $this->request->getPost('due_date'),
            'user_id'     => session()->get('user_id'),
        ]);
        return redirect()->to('/tasks')->with('message', 'Task created successfully.');
    }


    public function edit($id)
    {
        $task = $this->taskModel->find($id);
        if (! $task || $task['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found.');
        }
        return view('tasks/edit', ['task' => $task, 'title' => 'Edit Task']);
    }


    public function update($id)
    {
        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[1000]',
            'status'      => 'required|in_list[pending,in-progress,completed]',
            'due_date'    => 'permit_empty|valid_date',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $this->taskModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
            'due_date'    => $this->request->getPost('due_date'),
        ]);
        return redirect()->to('/tasks')->with('message', 'Task updated successfully.');
    }


    public function delete($id)
    {
        $task = $this->taskModel->find($id);
        if (! $task || $task['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Task not found.');
        }
        $this->taskModel->delete($id);
        return redirect()->to('/tasks')->with('message', 'Task deleted successfully.');
    }
}
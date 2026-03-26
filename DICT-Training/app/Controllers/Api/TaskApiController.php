<?php


namespace App\Controllers\Api;


use CodeIgniter\RESTful\ResourceController;
use App\Models\TaskModel;


class TaskApiController extends ResourceController
{
    protected $modelName = TaskModel::class;
    protected $format    = 'json';


    public function index()
    {
        return $this->respond($this->model->findAll());
    }


    public function show($id = null)
    {
        $task = $this->model->find($id);
        return $task ? $this->respond($task) : $this->failNotFound('Task not found.');
    }


    public function create()
    {
        $data = $this->request->getJSON(true);
        if (! $this->model->insert($data))
            return $this->failValidationErrors($this->model->errors());
        $data['id'] = $this->model->getInsertID();
        return $this->respondCreated($data, 'Task created.');
    }


    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if (! $this->model->find($id)) return $this->failNotFound('Task not found.');
        $this->model->update($id, $data);
        return $this->respond(['id' => $id, 'message' => 'Task updated.']);
    }


    public function delete($id = null)
    {
        if (! $this->model->find($id)) return $this->failNotFound('Task not found.');
        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id, 'message' => 'Task deleted.']);
    }
}

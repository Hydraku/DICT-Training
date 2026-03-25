<?php


namespace App\Database\Seeds;


use CodeIgniter\Database\Seeder;


class TaskSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['title' => 'Set up dev environment', 'description' => 'Install PHP 8.3, Composer, MySQL', 'status' => 'completed', 'due_date' => date('Y-m-d'), 'user_id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'Learn CI4 routing', 'description' => 'Understand defined routes', 'status' => 'in-progress', 'due_date' => date('Y-m-d', strtotime('+1 day')), 'user_id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['title' => 'Build CRUD operations', 'description' => 'Create, read, update, delete tasks', 'status' => 'pending', 'due_date' => date('Y-m-d', strtotime('+3 days')), 'user_id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('tasks')->insertBatch($data);
    }
}
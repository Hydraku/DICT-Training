<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Tasks</h2>

    <!-- Search Bar -->
    <form method="GET" action="/tasks" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search tasks by title..."
                value="<?= esc($search ?? '') ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
            <?php if (!empty($search)): ?>
                <a href="/tasks" class="btn btn-outline-danger">Clear</a>
            <?php endif; ?>
        </div>
    </form>

    <a href="/tasks/create" class="btn btn-primary">+ New Task</a>
</div>

<?php if (!empty($tasks)): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= esc($task['title']) ?></td>
                    <td>
                        <span class="badge bg-<?= match ($task['status']) {
                            'completed' => 'success',
                            'in-progress' => 'warning',
                            default => 'secondary',
                        } ?>"><?= esc($task['status']) ?></span>
                    </td>
                    <td><?= $task['due_date'] ? date('M d, Y', strtotime($task['due_date'])) : '-' ?></td>
                    <td>
                        <a href="/tasks/show/<?= $task['id'] ?>" class="btn btn-sm btn-outline-info">View</a>
                        <a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="/tasks/delete/<?= $task['id'] ?>" method="post" class="d-inline"
                            onsubmit="return confirm('Delete this task?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="card-footer mt-3 d-flex justify-content-center"><?= $pager->only(['search'])->links() ?></div>

<?php else: ?>
    <div class="alert alert-info">
        <?php if (!empty($search)): ?>
            No tasks found for <strong><?= esc($search) ?></strong>.
            <a href="/tasks">Clear search</a>.
        <?php else: ?>
            No tasks yet. <a href="/tasks/create">Create your first task</a>.
        <?php endif; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
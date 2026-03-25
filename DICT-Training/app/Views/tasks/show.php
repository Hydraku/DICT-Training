<?= $this->extend('layouts/main') ?>


<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?= esc($task['title']) ?></h2>
    <span class="badge bg-<?= match ($task['status']) {
                                'completed' => 'success',
                                'in-progress' => 'warning',
                                default => 'secondary',
                            } ?> fs-6"><?= esc($task['status']) ?></span>
</div>


<?php if ($task['due_date']): ?>
    <p class="text-muted">Due: <?= date('F d, Y', strtotime($task['due_date'])) ?></p>
<?php endif; ?>


<?php if ($task['description']): ?>
    <div class="card mb-3">
        <div class="card-body">
            <?= nl2br(esc($task['description'])) ?>
        </div>
    </div>
<?php endif; ?>


<p class="text-muted small">
    Created: <?= $task['created_at'] ?>
    <?php if ($task['updated_at'] !== $task['created_at']): ?>
        | Updated: <?= $task['updated_at'] ?>
    <?php endif; ?>
</p>


<a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-primary">Edit</a>
<form action="/tasks/delete/<?= $task['id'] ?>" method="post" class="d-inline"
    onsubmit="return confirm('Delete this task?')">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
<a href="/tasks" class="btn btn-secondary">Back to List</a>
<?= $this->endSection() ?>
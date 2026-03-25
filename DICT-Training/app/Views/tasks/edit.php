<?= $this->extend('layouts/main') ?>


<?= $this->section('content') ?>
<h2>Edit Task</h2>
<form action="/tasks/update/<?= $task['id'] ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="title" class="form-label">Title *</label>
        <input type="text" name="title" id="title"
            class="form-control" value="<?= old('title', $task['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description"
            class="form-control" rows="3"><?= old('description', $task['description']) ?></textarea>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label">Status *</label>
            <select name="status" id="status" class="form-select">
                <?php foreach (['pending', 'in-progress', 'completed'] as $s): ?>
                    <option value="<?= $s ?>"
                        <?= old('status', $task['status']) === $s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" id="due_date"
                class="form-control" value="<?= old('due_date', $task['due_date']) ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Update Task</button>
    <a href="/tasks" class="btn btn-secondary">Cancel</a>
</form>
<?= $this->endSection() ?>
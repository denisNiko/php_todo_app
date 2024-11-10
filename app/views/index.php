
<div class="container my-5">
    <h1 class="text-center mb-4">Todo List</h1>

    <!-- Add New Task Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Task</div>
        <div class="card-body">
            <form action="/todo_app_auth/?action=store" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter task title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter task description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>
    </div>

    <!-- Todo List Table -->
    <div class="card">
        <div class="card-header">Your Tasks</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td>
                            <textarea class="form-control" rows="2" readonly style="resize: none; overflow-y: scroll;">
                                <?php echo $task['description']; ?>
                            </textarea>
                        </td>
                        <td>
                            <!-- AJAX-based Status Change Button -->
                            <button
                                id="status-<?php echo $task['id']; ?>" 
                                class="btn btn-sm status-toggle <?php echo $task['status'] === 'pending' ? 'btn-warning' : 'btn-success'; ?>" 
                                data-id="<?php echo $task['id']; ?>"
                                data-status="<?php echo $task['status']; ?>">
                                <?php echo $task['status'] === 'pending' ? 'Pending' : 'Completed'; ?>
                            </button>
                        </td>
                        <td>
                            <!-- Edit Task Button (Modal Trigger) -->
                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editTaskModal<?php echo $task['id']; ?>">
                                Edit
                            </button>

                            <!-- Delete Task Button -->
                            <form action="/todo_app_auth/?action=delete&id=<?php echo $task['id']; ?>" method="POST" style="display:inline;">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Task Modal -->
                    <div class="modal fade" id="editTaskModal<?php echo $task['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel<?php echo $task['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTaskModalLabel<?php echo $task['id']; ?>">Edit Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/todo_app_auth/?action=update&id=<?php echo $task['id']; ?>" method="POST">
                                        <div class="form-group">
                                            <label for="title<?php echo $task['id']; ?>">Title</label>
                                            <input type="text" class="form-control" id="title<?php echo $task['id']; ?>" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description<?php echo $task['id']; ?>">Description</label>
                                            <textarea class="form-control" id="description<?php echo $task['id']; ?>" name="description" rows="3"><?php echo htmlspecialchars($task['description']); ?></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Edit Task Modal -->
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>



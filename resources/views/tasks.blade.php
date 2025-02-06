<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center">Task Manager</h2>

        <!-- Task Form -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Add New Task</h5>
                <form id="taskForm">
                    <div class="mb-3">
                        <input type="text" id="title" class="form-control" placeholder="Task Title" required>
                    </div>
                    <div class="mb-3">
                        <textarea id="description" class="form-control" placeholder="Task Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>

        <!-- Task List -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Task List</h5>
                <ul id="taskList" class="list-group"></ul>
            </div>
        </div>
    </div>

    <script>
        const API_URL = "/api/tasks";

        // Fetch and display tasks
        function fetchTasks() {
            fetch(API_URL)
                .then(response => response.json())
                .then(tasks => {
                    const taskList = document.getElementById("taskList");
                    taskList.innerHTML = "";

                    tasks.forEach(task => {
                        const taskItem = document.createElement("li");
                        taskItem.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
                        taskItem.innerHTML = `
                            <div>
                                <strong>${task.title}</strong> - ${task.description || "No Description"}
                                <span class="badge bg-${task.status === 'completed' ? 'success' : 'warning'}">
                                    ${task.status}
                                </span>
                            </div>
                            <div>
                                ${task.status === 'pending' ? `
                                    <button class="btn btn-sm btn-success" onclick="markCompleted(${task.id})">Complete</button>
                                ` : ''}
                                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Delete</button>
                            </div>
                        `;
                        taskList.appendChild(taskItem);
                    });
                });
        }

        // Add a new task
        document.getElementById("taskForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const title = document.getElementById("title").value;
            const description = document.getElementById("description").value;

            fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ title, description })
            })
            .then(response => response.json())
            .then(() => {
                document.getElementById("title").value = "";
                document.getElementById("description").value = "";
                fetchTasks();
            });
        });

        // Mark task as completed
        function markCompleted(id) {
            fetch(`${API_URL}/${id}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ status: "completed" })
            })
            .then(() => fetchTasks());
        }

        // Delete a task
        function deleteTask(id) {
            fetch(`${API_URL}/${id}`, { method: "DELETE" })
            .then(() => fetchTasks());
        }

        // Load tasks on page load
        fetchTasks();
    </script>

</body>
</html>
            
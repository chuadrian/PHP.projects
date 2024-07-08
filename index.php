<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List</title>
    <link rel='stylesheet' href="styles.css">
</head>
<body>
    <h1>To-Do List</h1>

    <!-- form to add a new task -->
    <form method="post" action="index.php">
        <label for="newTask">New Task:</label>
        <input type="text" id="newTask" name="newTask">
        <input type="submit" name="add" value="Add Task">
    </form>

    <!-- form to remove a task by its index -->
    <form method="post" action="index.php">
        <label for="removeTaskIndex">Task Number to Remove:</label>
        <input type="number" id="removeTaskIndex" name="removeTaskIndex" min="1">
        <input type="submit" name="remove" value="Remove Task">
    </form>

    <?php
    // start the session to store tasks
    session_start();

    // initialize the tasks array if it doesn't exist
    if (!isset($_SESSION['tasks'])) {
        $_SESSION['tasks'] = [];
    }

    // function to add a task
    function addTask(&$tasks, $task) {
        if (!empty($task)) {
            $tasks[] = htmlspecialchars($task); // sanitize user input
        }
    }

    // function to remove a task
    function removeTask(&$tasks, $index) {
        if (isset($tasks[$index])) {
            unset($tasks[$index]);
            $tasks = array_values($tasks); // reindex the array
        }
    }

    // function to display tasks
    function displayTasks($tasks) {
        if (empty($tasks)) {
            echo "<p>No tasks in the list.</p>";
        } else {
            echo "<ul>";
            foreach ($tasks as $index => $task) {
                echo "<li>" . ($index + 1) . ". " . $task . "</li>";
            }
            echo "</ul>";
        }
    }

    // handle form submissions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add'])) {
            addTask($_SESSION['tasks'], $_POST['newTask']);
        } elseif (isset($_POST['remove'])) {
            $index = (int)$_POST['removeTaskIndex'] - 1; // adjust for zero-based index
            removeTask($_SESSION['tasks'], $index);
        }
    }

    // display the current list of tasks
    echo "<h2>Current Tasks:</h2>";
    displayTasks($_SESSION['tasks']);
    ?>

</body>
</html>

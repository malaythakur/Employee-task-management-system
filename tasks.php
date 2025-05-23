<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    $tasks = get_all_tasks($conn);
    $users = get_all_users($conn);
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>All Tasks</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">All Tasks <a href="create_task.php"> Create Task</a></h4>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>
                <?php if ($tasks != 0) { ?>


                    <table class="main-table">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Title
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Assigned To
                            </th>

                            <th>
                                Action
                            </th>
                        </tr>
                        <?php $i = 0;
                        foreach ($tasks as $task) { ?>


                            <tr>
                                <td>
                                    <?= ++$i ?>
                                </td>
                                <td>
                                    <?= $task['title'] ?>
                                </td>
                                <td>
                                    <?= $task['description'] ?>
                                </td>
                                <td>
                                    <?php
                                        foreach($users as $user) { 
                                            if($user['id'] == $task['assigned_to']) {
                                                echo $user['full_name'];
                                    }}?>
                                </td>
                                <td>
                                    <a href="edit-task.php?id=<?= $task['id'] ?>" class="edit-btn">Edit </a>
                                    <a href="delete-task.php?id=<?= $task['id'] ?>" class="delete-btn">Delete </a>

                                </td>
                            </tr> <?php } ?>
                    </table>
                <?php } else { ?>
                    <h3>Empty </h3>

                <?php } ?>

            </section>
        </div>

        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(4)");
            active.classList.add("active");
        </script>
    </body>

    </html>

<?php } else {
    $em = "First LOGIN";
    header("Location: login.php?error=$em");
    exit();
}
?>
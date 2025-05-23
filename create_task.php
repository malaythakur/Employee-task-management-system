<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $users = get_all_users($conn);

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Manage Users</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">

    </head>

    <body>
        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
        <div class="body">
            <?php include "inc/nav.php" ?>
            <section class="section-1">
                <h4 class="title">Create Task </h4>
                <form class="form-1" method="POST" action="app/add-task.php">
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="danger" role="alert">
                            <?php echo stripcslashes($_GET['error']); ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($_GET['success'])) { ?>
                        <div class="success" role="alert">
                            <?php echo stripcslashes($_GET['success']); ?>
                        </div>
                    <?php } ?>

                    <div class="input-holder">
                        <lable>Title</lable>
                        <input type="text" name="title" class="input-1" value="<?php if (isset($_GET['title']))
                            echo htmlspecialchars($_GET['title']); ?>"><br>
                    </div>

                    <div class="input-holder">
                        <lable>Description</lable>
                        <textarea name="description" class="input-1"><?php
                        if (isset($_GET['description']))
                            echo htmlspecialchars($_GET['description']);
                        ?></textarea><br>
                    </div>

                    <div class="input-holder">
                        <lable>Assigned to</lable>
                        <select name="assigned_to" class="input-1" required>
                            <option value="0">Select Employee</option>
                            <?php if ($users != 0) {
                                foreach ($users as $user) {
                                    ?>
                                    <option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>

                                <?php }
                            } ?>

                        </select> <br>
                    </div>
                    <button class="edit-btn">Create Task</button>
                </form>

            </section>
        </div>

        <script type="text/javascript">
            var active = document.querySelector("#navList li:nth-child(3)");
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
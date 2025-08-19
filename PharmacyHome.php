<?php
require "connection.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Recieved Prescriptions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Recieved Prescriptions</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Client email</th>
                    <th>Client Contact No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = Database::search("SELECT `prescription`.`id`,`status`.`status`,`user`.`email`,`user`.`contact_no` FROM `prescription` INNER JOIN `user` ON `user`.`id`=`prescription`.`user_id` INNER JOIN `status` ON `status`.`id`=`prescription`.`status_id`");
                $n = $result->num_rows;

                for ($i = 0; $i < $n; $i++) {
                    $resultData = $result->fetch_assoc();
                ?>
                    <tr onclick="viewPrescription(<?php echo $resultData['id'] ?>)">
                        <td><?php echo $resultData["id"] ?></td>
                        <td><?php echo $resultData["status"] ?></td>
                        <td><?php echo $resultData["email"] ?></td>
                        <td><?php echo $resultData["contact_no"] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
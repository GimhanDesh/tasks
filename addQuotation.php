<?php
require "connection.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
  die("Prescription ID not provided!");
}

$prescriptionId = (int)$_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pharmacy Quotation - Medi_Lab</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .prescription-img {
      width: 100%;
      height: 250px;
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      color: #6c757d;
    }

    .thumb {
      width: 60px;
      height: 60px;
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      margin-right: 5px;
    }

    .status {
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 6px;
    }

    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }

    .status-accepted {
      background-color: #d4edda;
      color: #155724;
    }

    .status-rejected {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>

<body class="bg-light">

  <div class="container py-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="row g-4">
          <!-- Prescription Images -->
          <div class="col-md-5">
            <div class="prescription-img" id="mainPreview"><img src="assets/load.png" style="height:100%; width:100%; object-fit:contain;"></div>
            <div class="d-flex mt-2" id="imagePreview">
              <?php
              $result = Database::search("SELECT* FROM `image` WHERE `Prescription_id`='" . $prescriptionId . "';");
              $n = $result->num_rows;

              for ($i = 0; $i < $n; $i++) {
                $imageData = $result->fetch_assoc();
                if ($i == 0) {
                }
              ?>
                <div class="thumb"> <img src="<?php echo $imageData["path"]; ?>" style="height:100%; width:100%; object-fit:contain;"></div>
              <?php
              }
              ?>


            </div>
          </div>

          <!-- Quotation Table -->
          <div class="col-md-7">
            <h5 class="mb-3">Quotation</h5>
            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>Drug</th>
                  <th>Quantity</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                <?php
                $quotation = Database::search("SELECT * FROM quotation WHERE Prescription_id='" . $prescriptionId . "'");
                if ($quotation->num_rows < 1) {
                ?>
                  <tr>
                    <td colspan="3">NO Drugs Added</td>

                  </tr>
                  <?php
                } else {
                  $quotationData = $quotation->fetch_assoc();
                  $row = Database::search("SELECT `name`,`price`,`qty` FROM `quotation_has_drug` INNER JOIN `drug` ON `drug`.`id`=`quotation_has_drug`.`drug_id` WHERE `quotation_has_drug`.`quotation_id`='" . $quotationData["id"] . "'");
                  $rn = $row->num_rows;
                  for ($i = 0; $i < $rn; $i++) {
                    $rowData = $row->fetch_assoc();
                  ?>
                    <tr>
                      <td><?php echo $rowData["name"] ?></td>
                      <td><?php echo $rowData["price"] ?> x <?php echo $rowData["qty"] ?></td>
                      <td><?php echo $rowData["price"] * $rowData["qty"] ?></td>
                    </tr>

                  <?php
                  }
                  $quotResult = Database::search("SELECT id,total FROM quotation WHERE Prescription_id='" . $prescriptionId . "'");
                  if ($quotResult->num_rows == 1) {
                    $quotData = $quotResult->fetch_assoc();
                    $quotTotal = $quotData["total"];
                  }
                  ?>
                  <tr class="fw-bold">
                    <td colspan="2" class="text-end">Total</td>
                    <td><?php echo $quotTotal ?></td>
                  </tr>
                <?php
                }
                ?>


              </tbody>
            </table>

            <!-- Add Drug Form -->
            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <select class="form-control" id="drug">
                  <option value="0">Select Drug Here</option>
                  <?php
                  $drugResult = Database::search("SELECT * FROM drug");
                  $dn = $drugResult->num_rows;
                  for ($i = 0; $i < $dn; $i++) {
                    $drugData = $drugResult->fetch_assoc();
                  ?>
                    <option value="<?php echo $drugData["id"] ?>"><?php echo $drugData["name"] ?></option>
                  <?php
                  }
                  ?>
                </select>

              </div>
              <div class="col-md-4">
                <input type="number" class="form-control" placeholder="Quantity" id="qty" required>
              </div>
              <div class="col-md-2 d-grid">
                <button class="btn btn-primary" onclick="addDrugs(<?php echo $prescriptionId ?>)">Add</button>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <button class="btn btn-success" onclick="changeStatus(<?php echo $prescriptionId ?>,3)">Send Quotation</button>
              <?php
              $statusresult = Database::search("SELECT `status` FROM `prescription` INNER JOIN `status` ON `status`.`id`=`prescription`.`status_id`  WHERE `prescription`.`id`='" . $prescriptionId . "'");
              if ($statusresult->num_rows == 1) {
                $statusData = $statusresult->fetch_assoc();
              ?>
                <span class="status status-pending"><?php echo $statusData["status"] ?></span>
              <?php
              }
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    const mainPreview = document.getElementById("mainPreview").querySelector("img");
    const thumbs = document.querySelectorAll("#imagePreview .thumb img");

    thumbs.forEach(thumb => {
      thumb.addEventListener("click", () => {
        mainPreview.src = thumb.src; // change main image
      });
    });
  </script>
  <script>

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
<?php
session_start();
require "connection.php";
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Prescription & Quotation - Medi_Lab</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .prescription-box {
      border: 2px dashed #6c757d;
      border-radius: 10px;
      padding: 40px;
      text-align: center;
      background: #f8f9fa;
      cursor: pointer;
    }

    .prescription-box:hover {
      background: #e9ecef;
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
    <div class="row g-4">

      <!-- Upload Prescription -->
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="mb-3">Upload Prescription</h5>
            <div>
              <div class="mb-3">
                <label for="prescription" class="form-label">Upload Image / PDF</label>
                <input class="form-control" name="image[]" type="file" id="prescription" multiple required>
              </div>
              <div class="mb-3">
                <div class="prescription-box" id="dropZone">
                  <p class="mb-0 text-muted">Drag & Drop files here or click to browse</p>
                </div>
              </div>
              <button class="btn btn-primary" onclick="uploadImgs()">Upload</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Quotation Section -->
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="mb-3">Quotation from Pharmacy</h5>
            <?php
            $userId = $_SESSION["user"]["id"];
            $quotationResult = Database::search("SELECT quotation.id,prescription_id,total,status_id FROM prescription INNER JOIN quotation ON quotation.Prescription_id=prescription.id WHERE user_id='" . $userId . "' AND status_id=3");
            if ($quotationResult->num_rows >= 1) {
              for ($d = 0; $d < $quotationResult->num_rows; $d++) {
                $quotationData = $quotationResult->fetch_assoc();
            ?>
                <table class="table table-bordered mt-2">
                  <thead class="table-light">
                    <tr>
                      <th>Drug</th>
                      <th>Quantity</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody id="tableBody">
                  <?php
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
                  $quotResult = Database::search("SELECT id,total FROM quotation WHERE Prescription_id='" . $quotationData["prescription_id"] . "'");
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
                
                ?>

                  </tbody>
                </table>

                <!-- Accept / Reject Buttons -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div class="btn-group">
                    <button class="btn btn-success" onclick="changeStatus(<?php echo $quotationData['prescription_id']?>,1)">Accept</button>
                    <button class="btn btn-danger" onclick="changeStatus(<?php echo $quotationData['prescription_id']?>,2)">Reject</button>
                  </div>
                  <!-- Status Example -->
                  <span class="status status-pending">Pending</span>
                  <!-- Change class to status-accepted / status-rejected dynamically -->
                </div>

<?php
                }  }          


              

             ?>    
                  
                 
          </div>
        </div>
      </div>

    </div>
  </div>
  <script>
    let dropZone = document.getElementById("dropZone");
    let fileInput = document.getElementById("prescription");

    // Drag events
    dropZone.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropZone.classList.add("dragging");
    });
    dropZone.addEventListener("dragleave", () => {
      dropZone.classList.remove("dragging");
    });
    dropZone.addEventListener("drop", (e) => {
      e.preventDefault();
      dropZone.classList.remove("dragging");
      fileInput.files = e.dataTransfer.files; // assign dropped files
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
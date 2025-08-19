<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);
require "connection.php";

$prescriptionId = (int)$_POST["id"];
$drugId = (int)$_POST["drug"];
$qty = (int)$_POST["qty"];

if (!$prescriptionId || !$drugId || !$qty) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$quotation = Database::search("SELECT * FROM quotation WHERE Prescription_id='" . $prescriptionId . "'");
if ($quotation->num_rows == 0) {
    Database::iud("INSERT INTO quotation(Prescription_id,total) VALUES('" . $prescriptionId . "',0)");
    $quotationId = Database::$connection->insert_id;
} else {
    $quotationId = $quotation->fetch_assoc()["id"];
}

$drugResult = Database::search("SELECT * FROM drug WHERE id='" . $drugId . "'");
if ($drugResult->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Drug not found"]);
    exit;
}
$drug = $drugResult->fetch_assoc();


Database::iud("INSERT INTO quotation_has_drug(quotation_id,drug_id,qty) VALUES('" . $quotationId . "','" . $drugId . "','" . $qty . "')");

$quotResult = Database::search("SELECT id,total FROM quotation WHERE Prescription_id='" . $prescriptionId . "'");
if ($quotResult->num_rows == 1) {
    $quotData = $quotResult->fetch_assoc();
    $quotTotal = $quotData["total"];

    $amount = $drug["price"] * $qty;

    $quotTotal += $amount;

    Database::iud("UPDATE quotation SET total='" . $quotTotal . "' WHERE id='" . $quotData["id"] . "'");

    $row = Database::search("SELECT `name`,`price`,`qty` FROM `quotation_has_drug` INNER JOIN `drug` ON `drug`.`id`=`quotation_has_drug`.`drug_id` WHERE `quotation_has_drug`.`quotation_id`='" . $quotData["id"] . "'");
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
    ?>
    <tr class="fw-bold">
        <td colspan="2" class="text-end">Total</td>
        <td><?php echo $quotTotal ?></td>
    </tr>
<?php


}

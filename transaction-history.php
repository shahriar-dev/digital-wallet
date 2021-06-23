<?php
$TotalRecords = "";
$TransactionCategory = "";
$Amount = "";
$To = "";
$TransferredOn = "";

define("filepath", "data.txt");
$retrievedData = json_decode(file_get_contents(filepath));
$TotalRecords = count($retrievedData);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
</head>

<body>
    <h1>Page 2 [Transaction History]</h1>
    <h3>Digital Wallet</h3>

    <span>
        <table>
            <style>
                td {
                    padding-right: 20px;
                }
            </style>
            <tr>
                <td><a href="home.php">1. Home</a></td>
                <td><a href="transaction-history.php">2. Transaction History</a></td>
            </tr>
        </table>
    </span>

    <?php echo "<h3>Total Records:(" . $TotalRecords . ")</h3>" ?>

    <table>
        <tr>
            <th>Transaction Category</th>
            <th>To</th>
            <th>Amount</th>
            <th>Transferred On</th>
        </tr>
        <?php
        if ($retrievedData != null) {
            foreach ($retrievedData as $obj) {
                echo '<tr> <td>' . $obj->{'Type'} . '</td>
                        <td>' . $obj->{'To'} . '</td>
                        <td>' . $obj->{'Amount'} . '</td>
                        <td>' . $obj->{'Time'} . '</td></tr>';
            }
        }
        ?>
    </table>
</body>

</html>
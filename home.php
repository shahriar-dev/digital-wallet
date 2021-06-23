<?php
$Category = "";
$CategoryError = "";
$PhoneNumber = "";
$PhoneNumberError = "";
$Amount = "";
$AmountError = "";
$Default = "Select a Value";

$EmptyField = false;
define("filepath", "data.txt");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        $CategoryType = Test_User_Input($_POST['selected_option']);
        if ($CategoryType == "Select a Value") {
            $CategoryError = "Please SELECT a CATEGORY!";
            $EmptyField = true;
        }
        if (empty($_POST["amount"])) {
            $AmountError = "You must amount!";
            $EmptyField = true;
        }
        if (empty($_POST["phoneNumber"])) {
            $PhoneNumberError = "You must enter a PHONE NUMBER!";
            $EmptyField = true;
        }
        if ($CategoryType == "Send Money") {
            $Default = "Send Money";
            if (empty($_POST["phoneNumber"])) {
                $PhoneNumberError = "You must enter a PHONE NUMBER!";
                $EmptyField = true;
            } else {
                $PhoneNumber = Test_User_Input($_POST["phoneNumber"]);
                //$Type1 = preg_match("/^(8801)[0-9]{9}$/", $PhoneNumber);
                $Type2 = preg_match("/^[0-9]{11}+$/", $PhoneNumber);
                if (!$Type2) {
                    $PhoneNumberError = "Must be valid BANGLADESHI NUMBER!";
                    $EmptyField = true;
                }
            }

            if (empty($_POST["amount"])) {
                $AmountError = "You must enter a PHONE NUMBER!";
                $EmptyField = true;
            } else {
                $Amount = Test_User_Input($_POST["amount"]);

                if (!preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $Amount) || (int)$Amount < (int)"0") {
                    $AmountError = "Must be > 0!";
                    $EmptyField = true;
                }
            }
        } else if ($CategoryType == "Recharge") {
            $Default = "Recharge";
            if (empty($_POST["phoneNumber"])) {
                $PhoneNumberError = "You must enter a PHONE NUMBER!";
                $EmptyField = true;
            } else {
                $PhoneNumber = Test_User_Input($_POST["phoneNumber"]);
                //$Type1 = preg_match("/^(\+8801)[0-9]{9}$/", $PhoneNumber);
                $Type2 = preg_match("/^[0-9]{11}+$/", $PhoneNumber);
                if (!$Type2) {
                    $PhoneNumberError = "Must be valid BANGLADESHI NUMBER!";
                    $EmptyField = true;
                }
            }

            if (empty($_POST["amount"])) {
                $AmountError = "You must enter a PHONE NUMBER!";
                $EmptyField = true;
            } else {
                $Amount = Test_User_Input($_POST["amount"]);
                if (!preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $Amount) || (int)$Amount < (int)"0") {
                    $AmountError = "Must be > 0!";
                    $EmptyField = true;
                }
            }
        } elseif ($CategoryType == "Merchent Pay") {
            $Default = "Pay Merchant";
            if (empty($_POST["phoneNumber"])) {
                $PhoneNumberError = "You must enter a PHONE NUMBER!";
                $EmptyField = true;
            } else {
                $PhoneNumber = Test_User_Input($_POST["phoneNumber"]);
                //$Type1 = preg_match("/^(\+8801)[0-9]{9}$/", $PhoneNumber);
                $Type2 = preg_match("/^[0-9]{11}+$/", $PhoneNumber);
                if (!$Type1 || !$Type2) {
                    if (!preg_match()) {
                        $PhoneNumberError = "Must be valid BANGLADESHI NUMBER!";
                        $EmptyField = true;
                    }
                }

                if (empty($_POST["amount"])) {
                    $AmountError = "You must enter a PHONE NUMBER!";
                    $EmptyField = true;
                } else {
                    $Amount = Test_User_Input($_POST["amount"]);
                    if (!preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $Amount) || (int)$Amount < (int)"0") {
                        $AmountError = "Must be > 0!";
                        $EmptyField = true;
                    }
                }
            }
        }

        if (!$EmptyField) {
            $d = strtotime("today");
            $data = array(
                "Type" => $Default, "To:" => $PhoneNumber, "Amount" => $Amount, "Time" => date("Y-m-d h:i:sa", $d)
            );

            if (file_get_contents(filepath) != null) {

                $retrievedData = json_decode(file_get_contents(filepath));
                $retrievedData[] = $data;
                $result = file_put_contents(filepath, json_encode($retrievedData, JSON_PRETTY_PRINT));
                if ($result) {
                    $SuccessfulMessage = "Successfully Saved!";
                } else {
                    $SuccessfulMessage = "Error Saving Information!";
                }
            } else {
                $retrievedData[] = $data;
                $result = file_put_contents(filepath, json_encode($retrievedData, JSON_PRETTY_PRINT));
                if ($result) {
                    $SuccessfulMessage = "Successfully Saved!";
                } else {
                    $SuccessfulMessage = "Error Saving Information!";
                }
            }
        }
    }
}
function Test_User_Input($Data)
{
    return trim(htmlspecialchars(stripcslashes($Data)));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Digital Wallet</title>
</head>

<body>
    <h1>Page 1 [Home]</h1>
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

    <h3>Fund Transfer</h3>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <span>
                <label for="selected_category">Select Catergory:</label>

                <select name="selected_option" id="selected_category" value="<?php echo $Default; ?>">
                    <option default><?php echo $Default; ?></option>
                    <option name="option_sendMoney">Send Money</option>
                    <option name="option_rechargeMoney">Recharge</option>
                    <option name="option_payMarchent">Merchent Pay</option>
                </select>
                <label for="error_inputCategory" style="color: red;"><?php echo "<b>$CategoryError</b>" ?></label>
            </span>

            <span>
                <br>
                <br>
                <label for="input_phone">To: </label>
                <input type="text" id="input_phone" name="phoneNumber" value="<?php echo $PhoneNumber; ?>">
                <label for="error_inputPhone" style="color: red;"><?php echo "<b>$PhoneNumberError</b>" ?></label>
            </span>
            <span>
                <br>
                <br>
                <label for="input_amount">Amount: </label>
                <input type="text" id="input_amount" name="amount" value="<?php echo $Amount; ?>">
                <label for="error_inputAmmount" style="color: red;"><?php echo "<b>$AmountError</b>" ?></label>
            </span>



            <span>
                <br><br>
                <input type="submit" name="submit"> &nbsp;&nbsp;
                <input type="reset" value="Reset">
            </span>
        </form>
    </div>
</body>

</html>
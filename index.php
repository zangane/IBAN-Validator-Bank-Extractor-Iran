<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBAN Validator & Bank Extractor (Iran)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>IBAN Validator & Bank Extractor (Iran)</h1>
        <form method="post">
            <label for="iban">Enter Iranian IBAN Number:</label>
            <input type="text" name="iban" id="iban" placeholder="IRxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
            <button type="submit">Validate IBAN</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["iban"])) {
            $iban = strtoupper(trim($_POST["iban"]));

            // Validate and extract bank details
            if (validate_iban($iban)) {
                $bank_name = extract_bank_name($iban);
                echo "<p style='color: green;'>Valid IBAN! Associated Bank: $bank_name</p>";
            } else {
                echo "<p style='color: red;'>Invalid IBAN format. Please check and try again.</p>";
            }
        }

        function validate_iban($iban) {
            // Check if IBAN starts with 'IR' and is 26 characters long
            if (substr($iban, 0, 2) === 'IR' && strlen($iban) === 26) {
                // Check if all characters are alphanumeric (letters and digits)
                return preg_match("/^[A-Z0-9]+$/", $iban);
            }
            return false;
        }

        function extract_bank_name($iban) {
            // The bank code is in positions 4 to 6 of the IBAN
            $bank_code = substr($iban, 2, 3);

            // Map of bank codes to bank names
            $bank_names = [
                '001' => 'Bank Melli Iran',
                '002' => 'Bank Saderat Iran',
                '003' => 'Bank Tejarat',
                '004' => 'Bank Mellat',
                '005' => 'Bank Pasargad',
                '006' => 'Bank Sepah',
                '007' => 'Bank Keshavarzi',
                '008' => 'Bank of Industry and Mine',
                // Add more bank codes and names as needed
            ];

            return isset($bank_names[$bank_code]) ? $bank_names[$bank_code] : 'Unknown Bank';
        }
        ?>
    </div>
</body>
</html>

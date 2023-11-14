<?php
$apiUrl = 'http://127.0.0.1:5022/diabetes';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data and make the API request
    
    // Set the values of the parameters to pass to the model
    $arg_pregnant = $_POST['arg_pregnant'];
    $arg_glucose = $_POST['arg_glucose'];
    $arg_pressure = $_POST['arg_pressure'];
    $arg_triceps = $_POST['arg_triceps'];
    $arg_insulin = $_POST['arg_insulin'];
    $arg_mass = $_POST['arg_mass'];
    $arg_pedigree = $_POST['arg_pedigree'];
    $arg_age = $_POST['arg_age'];

    $params = array(
        'arg_pregnant' => $arg_pregnant,
        'arg_glucose' => $arg_glucose,
        'arg_pressure' => $arg_pressure,
        'arg_triceps' => $arg_triceps,
        'arg_insulin' => $arg_insulin,
        'arg_mass' => $arg_mass,
        'arg_pedigree' => $arg_pedigree,
        'arg_age' => $arg_age
    );

    // Set the cURL options
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Make the request
    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        die("cURL Error: $error");
    }

    // Close cURL session/resource
    curl_close($curl);

    // Process the response
    $data = json_decode($response, true);

    if (isset($data['0'])) {
        // API request was successful
        echo "The predicted diabetes status is:<br>";
        foreach ($data as $repository) {
            echo $repository['0'], $repository['1'], $repository['2'], "<br>";
        }
    } else {
        // API request failed or returned an error
        echo "API Error: " . $data['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diabetes Form</title>
</head>
<body>
    <h1>Diabetes Form</h1>
    <form method="post" action="">
        <!-- Add input fields for each parameter -->
        Pregnant: <input type="number" name="arg_pregnant" required><br>
        Glucose: <input type="number" name="arg_glucose" required><br>
        Pressure: <input type="number" name="arg_pressure" required><br>
        Triceps: <input type="number" name="arg_triceps" required><br>
        Insulin: <input type="number" name="arg_insulin" required><br>
        Mass: <input type="number" name="arg_mass" required><br>
        Pedigree: <input type="number" step="0.001" name="arg_pedigree" required><br>
        Age: <input type="number" name="arg_age" required><br>
        <button type="submit">Predict</button>
    </form>
</body>
</html>

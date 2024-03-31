<?php
// Check if the 'i' parameter is set in the URL
if (isset($_GET['i'])) {
    // Get the value of 'i'
    $timestamp = $_GET['i'];
    
    // Output the timestamp
    //echo "Timestamp received: $timestamp";
} else {
    // 'i' parameter is not set
    //echo "Error: 'i' parameter not found in the URL";
}
?>


<?php
// Set the endpoint URL
$url = "https://api.openai.com/v1/chat/completions";

// Set the request headers
$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer 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" // Replace YOUR_OPENAI_API_KEY with your actual API key
);

// Set the request body
$data = array(
    "model" => "gpt-3.5-turbo",
    "messages" => array(
        array("role" => "system", "content" => "You are a helpful assistant."),
        array("role" => "user", "content" =>  "explain the object based on these dense captions 
        'A laptop with a logo on the back'
        'A laptop with a white cover'
         to a k12 student and dont mention the first caption or second or third caption in response just explain everything to user and answer dont mention anything related to captions")
    )
);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo "cURL Error: " . curl_error($ch);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);
    
    // Output the response data
    var_dump($responseData);
}

// Close cURL session
curl_close($ch);
?>



<?php

function azure_AI(){
// Set the endpoint URL
$url = "https://xperig.openai.azure.com/openai/deployments/ARI/chat/completions?api-version=2024-02-15-preview";

// Set the request headers
$headers = array(
    "Content-Type: application/json",
    "api-key: xxxxxxxxxxxxxxxxxxxx" // Replace YOUR_API_KEY with your actual API key
);

// Set the request body
$data = array(
    "messages" => array(
        array("role" => "system", "content" => "You are an AI assistant that helps people find information."),
        array("role" => "user", "content" => "explain the object based on these dense captions 'A laptop with a logo on the back
        A laptop with a white cover' to a k12 student and dont mention the first caption or second or third caption in response just explain everything to user and answer dont mention anything related to captions")
    ),
    "max_tokens" => 800,
    "temperature" => 0.7,
    "frequency_penalty" => 0,
    "presence_penalty" => 0,
    "top_p" => 0.95,
    "stop" => null
);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo "cURL Error: " . curl_error($ch);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);
    var_dump($responseData);
// Check if the 'choices' key exists in the response
if (isset($responseData['choices']) && is_array($responseData['choices'])) {
    // Access the first choice (assuming there's only one choice)
    $firstChoice = $responseData['choices'][0];

    // Check if the 'message' key exists in the choice
    if (isset($firstChoice['message'])) {
        // Access the content of the message
        $messageContent = $firstChoice['message']['content'];

        // Output the content of the message
        echo "Message content: $messageContent";
        var_dump($responseData);
    } else {
        echo "Error: 'message' key not found in the response";
    }
} else {
    echo "Error: 'choices' key not found in the response";
}


}

// Close cURL session
curl_close($ch);
}
?>


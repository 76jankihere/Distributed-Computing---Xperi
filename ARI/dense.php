<?php
$f= '';
if (isset($_GET['i'])) {
    // Get the value of 'i'
    $f = $_GET['i'].'.png';
    dense('');
} else {
    die();
}
?>

<?php
function dense($f){
// Azure Cognitive Services credentials
$subscription_key = '';
$endpoint = 'https://eastus.api.cognitive.microsoft.com';
if(!empty($f)){
    $image_url = 'https://nextio.in/ARI/uploads/'.$f;
}
else{
// Image URL
$image_url = 'https://static.wikia.nocookie.net/the-snack-encyclopedia/images/7/7d/Apple.png/revision/latest?cb=20200706145821';
}

// Request parameters
$request_params = [
    'api-version' => '2024-02-01',
    'features' => 'denseCaptions',
    'model-version' => 'latest',
    'language' => 'en',
    'gender-neutral-caption' => 'True'
];

// Prepare request headers
$headers = [
    'Content-Type: application/json',
    'Ocp-Apim-Subscription-Key: ' . $subscription_key
];

// Prepare request body
$request_body = json_encode(['url' => $image_url]);

// Initialize cURL session
$ch = curl_init($endpoint . '/computervision/imageanalysis:analyze?' . http_build_query($request_params));

// Set cURL options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

// Close cURL session
curl_close($ch);
$c = '';
// Parse and display response
$response_data = json_decode($response, true);
if (isset($response_data['denseCaptionsResult']['values'])) {
    $dense_captions = $response_data['denseCaptionsResult']['values'];

    foreach ($dense_captions as $caption) {
        $c=  $caption['text'] . $c;
    }
    //echo $c;
    azure_AI($c);
} else {
    echo "No dense captions found.";
}
}
?>

<?php

function azure_AI($c){
// Set the endpoint URL
$url = "https://xperig.openai.azure.com/openai/deployments/ARI/chat/completions?api-version=2024-02-15-preview";

// Set the request headers
$headers = array(
    "Content-Type: application/json",
    "api-key: " 
);
$s = 'masters';
// Set the request body
$data = array(
    "messages" => array(
        array("role" => "system", "content" => "You are an AI assistant that identifies object based on provide desciption and gives students all information relatyed to object identified based on desciption."),
        array("role" => "user", "content" => 
        "concluded or assume the object based on these 
        discriptions 
         ". $c . " explain about conculded object 
         and in response just explain everything completly 
         related to the object ")
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
    //var_dump($responseData);
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
        //var_dump($responseData);
    } else {
        echo "Error: API limit exceed wait 30s";
    }
} else {
    echo "Error: API limit exceed wait 30s";
}


}

// Close cURL session
curl_close($ch);
}
?>

<?php
function openai(){
// Set the endpoint URL
$url = "https://api.openai.com/v1/chat/completions";

// Set the request headers
$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer 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" // Replace YOUR_OPENAI_API_KEY with your actual API key
);
$s = 'masters';
// Set the request body
$data = array(
    "model" => "gpt-3.5-turbo",
    "messages" => array(
        array("role" => "system", "content" => "You are a helpful assistant."),
        array("role" => "user", "content" =>  "concluded or assume the object based on these dense captions 
        'A laptop with a logo on the back'
        'A laptop with a white cover'
         and explain about conculded object to a student studying " .$s ." student and dont mention the first caption or second or third caption in response just explain everything completly educationally related to the object as per student education level")
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
}
?>
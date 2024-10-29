<?php
error_reporting(0);
system ('clear');

$file=file("user_agent");
if(empty("$file")){
	
		user_agent:
	
	
	$user_agent=readline("\033[41m\033[97m[+] Input User_agent \033[0m\033[91m➥\033[0m\033[0m ");
	echo"\033[0m";
	
	$txt="$user_agent";
	$file=fopen("user_agent","w");
  fwrite($file,$txt);
  
	}else{
		
	
}

$file=file("config");
if(empty("$file")){
	
	cookie:

		

	
	$coc=readline("\033[41m\033[97m[+] input cookie \033[0m\033[91m➥\033[0m\033[0m ");
	echo"\033[0m";
	system ('clear');
	$txt="$coc";
	$file=fopen("config","w");
  fwrite($file,$txt);
  system ('clear');
	}else{
		
	
}
$file=file("payeer");
if(empty("$file")){
	
	payeer:

		

	
	$payeer=readline("\033[41m\033[97m[+] input payeer wallet \033[0m\033[91m➥\033[0m\033[0m ");
	echo"\033[0m";
	system ('clear');
	$txt="$payeer";
	$file=fopen("payeer","w");
  fwrite($file,$txt);
 // system ('clear');
	}else{
		
	
}
$file=file("withd_amount");
if(empty("$file")){
	withd_amount:
	

		

	
	$withd_amount=readline("\033[41m\033[97m[+] input withdrawal amount \033[0m\033[91m➥\033[0m\033[0m ");
	echo"\033[0m";
	system ('clear');
	$txt="$withd_amount";
	$file=fopen("withd_amount","w");
  fwrite($file,$txt);
  system ('clear');
	}else{
		
	
}



system ('clear');
$file=file("config");
$line= $file[0];
$cookie=trim($line);
if (empty($cookie)){goto cookie;}

$file=file("withd_amount");
$line= $file[0];
$withd_amount=trim($line);
if (empty($withd_amount)){goto withd_amount;}

$file=file("user_agent");
$line= $file[0];
$user_agent=trim($line);
if (empty($user_agent)){goto user_agent;}

$file=file("payeer");
$line= $file[0];
$payeer=trim($line);
if (empty($payeer)){goto payeer;}

function user_info($response){
date_default_timezone_set('Asia/Dhaka');
$ntime = date('H:i:s');
// Use DOMDocument to parse the HTML
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

// Initialize XPath
$xpath = new DOMXPath($dom);

// Helper function to get text content safely
function getTextContent($nodeList) {
    return ($nodeList->length > 0) ? trim($nodeList->item(0)->textContent) : 'N/A';
}

// Extract the required information
$username = getTextContent($xpath->query("//font[@class='text-success']"));
$balance = getTextContent($xpath->query("//b[@id='sidebarCoins']"));
$coinUsdValue = getTextContent($xpath->query("//div[contains(@class, 'text-success')]/b"));
$membership = getTextContent($xpath->query("//a[contains(@href, 'membership.html')]/b"));
$validUntil = trim(explode("<", explode('membership.html" class="text-info"><b>', $response)[1])[0]);
$todayClaims = getTextContent($xpath->query("//a[contains(@href, 'rewards.html')][contains(@class, 'text-dark')]/b"));
$totalClaims = getTextContent($xpath->query("//a[contains(@href, 'rewards.html')][contains(@class, 'text-danger')]/b"));

// Format balance for professional look
$balanceFormatted = "{$balance}/{$coinUsdValue}";

// Custom styling for terminal (using ANSI color codes)
$cyan = "\033[0;36m";
$green = "\033[0;32m";
$reset = "\033[0m";
$bold = "\033[1m";
$line = str_repeat("─", 40);

// Calculate padding for center alignment
$terminalWidth = 2;  // Assuming terminal width is 80
$boxWidth = 1;        // Width of the box
$paddingLeft = str_repeat(" ", intdiv(($terminalWidth - $boxWidth), 2)); // Center padding for box

// Display personalized header with username and emoji
echo "\n";
echo "{$paddingLeft}{$green}{$bold}┌{$line}┐{$reset}\n";
echo "{$paddingLeft}{$green}{$bold}│       Welcome, {$username}! Hi 👋            │{$reset}\n";
echo "{$paddingLeft}{$green}{$bold}└{$line}┘{$reset}\n";

echo "{$paddingLeft}┌───────────────┬──────────────────────────┐\n";
echo "{$paddingLeft}│ {$bold}Field         {$reset}│ {$bold}Value                   {$reset} │\n";
echo "{$paddingLeft}├───────────────┼──────────────────────────┤\n";
echo "{$paddingLeft}│ Username      │ {$cyan}" . str_pad($username, 24) . "{$reset} │\n";
echo "{$paddingLeft}│ Balance       │ {$cyan}" . str_pad($balanceFormatted, 24) . "{$reset} │\n";
echo "{$paddingLeft}│ Membership    │ {$cyan}" . str_pad($membership, 24) . "{$reset} │\n";
echo "{$paddingLeft}│ Valid Until   │ {$cyan}" . str_pad($validUntil, 24) . "{$reset} │\n";
echo "{$paddingLeft}│ Today Claims  │ {$cyan}" . str_pad($todayClaims, 24) . "{$reset} │\n";
echo "{$paddingLeft}│ Total Claims  │ {$cyan}" . str_pad($totalClaims, 24) . "{$reset} │\n";
echo "{$paddingLeft}└───────────────┴──────────────────────────┘\n";

$line = str_repeat("─", 65);
echo "$line \n";
}






function withdrawal($tk,$bal){



	global $h1,$user_agent,$ntime,$cookie,$payeer;
	$url="https://earnbitmoon.club/system/ajax.php";
	$data="a=sendWithdraw&token=$tk&method=4&amount=$bal&coin=USD&address=$payeer";
	$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $h1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
$json= json_decode($response);
 $status=$json->status;
	
 $responseData = json_decode($response, true);

// Extract the message text without HTML tags
if ($responseData && isset($responseData['message'])) {
    // Strip tags and echo only the text
    $mes = strip_tags(html_entity_decode($responseData['message']));
} else {
    
}
 
 if($status=="200"){
 	echo "\033[32m $ntime $mes $payeer \033[0m\n ";
 	}else{
 	echo " error $mes \n";
 }
 
 
 }
 
 

$url="https://earnbitmoon.club";
$h1=array(
    "Host: earnbitmoon.club",
    "sec-ch-ua-platform: \"Android\"",
    "x-requested-with: XMLHttpRequest",
    "user-agent: $user_agent",
    "sec-ch-ua: \"Android WebView\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?1",
    "accept: */*",
    "origin: https://earnbitmoon.club",
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://earnbitmoon.club/",
    "accept-language: en-BD,en-US;q=0.9,en;q=0.8",
    "cookie: $cookie");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $h1);
$response = curl_exec($ch);
	
user_info($response);



f:

date_default_timezone_set('Asia/Dhaka');
$ntime = date('H:i:s');
$url="https://earnbitmoon.club";
$h1=array(
    "Host: earnbitmoon.club",
    "sec-ch-ua-platform: \"Android\"",
    "x-requested-with: XMLHttpRequest",
    "user-agent: $user_agent",
    "sec-ch-ua: \"Android WebView\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?1",
    "accept: */*",
    "origin: https://earnbitmoon.club",
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://earnbitmoon.club/",
    "accept-language: en-BD,en-US;q=0.9,en;q=0.8",
    "cookie: $cookie");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $h1);
$response = curl_exec($ch);

                        
$dayb=explode('</',explode('<span class="badge badge-info">',$response)[2])[0];
 
$tk =trim(explode("'", explode("var token = '", $response)[1])[0]);
if(empty($tk)){
	//echo "account block or not Cookes expired \n";
	}else{
		
if($dayb=="0"){
	}else{
		$url="https://earnbitmoon.club/system/ajax.php?a=dailyBonus";
		$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $h1);
$result = curl_exec($ch);

$drc=explode(' Coins',explode('received ',$result)[1])[0];
if(empty ($drc)){
}else{
echo "[ $ntime ] daily bonus reward $drc \n";
}
}}
a:
// Define the URL for the POST request
$url = "https://earnbitmoon.club/system/libs/captcha/request.php";

// Define a new boundary for multipart/form-data
$new_boundary = "----NewBoundaryString123";

// Prepare the payload with the current timestamp
$payload = [
    "i" => 1,
    "a" => 1,
    "t" => "dark",
    "ts" => round(microtime(true) * 1000)  // Current timestamp in milliseconds
];

// Convert the payload to JSON and then to Base64
$payload_json = json_encode($payload);
 $payload_base64 = base64_encode($payload_json);


// Construct the multipart body
$body = "--$new_boundary\r\n";
$body .= "Content-Disposition: form-data; name=\"payload\"\r\n\r\n";
$body .= "$payload_base64\r\n";
$body .= "--$new_boundary--\r\n";

// Initialize cURL session for the POST request
$ch = curl_init($url);

// Set cURL options for the POST request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: earnbitmoon.club",
    "sec-ch-ua-platform: \"Android\"",
    "x-requested-with: XMLHttpRequest",
    "user-agent: $user_agent",
    "sec-ch-ua: \"Android WebView\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?1",
    "accept: */*",
    "origin: https://earnbitmoon.club",
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://earnbitmoon.club/",
    "accept-language: en-BD,en-US;q=0.9,en;q=0.8",
    "Content-Type: multipart/form-data; boundary=$new_boundary",
    "cookie: $cookie"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);
curl_close($ch);
//exit($response);

// URL for the GET request with Base64 encoded payload
$url = "https://earnbitmoon.club/system/libs/captcha/request.php?payload=" . $payload_base64;

// Prepare the headers for the GET request
$headers = [
    "Host: earnbitmoon.club",
    'sec-ch-ua-platform: "Android"',
    'user-agent: '.$user_agent.'',
    'sec-ch-ua: "Android WebView";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    'sec-ch-ua-mobile: ?1',
    'accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
    'x-requested-with: mark.via.gq',
    'sec-fetch-site: same-origin',
    'sec-fetch-mode: no-cors',
    'sec-fetch-dest: image',
    'referer: https://earnbitmoon.club/',
    'cookie: '.$cookie.''];

// Initialize cURL session for the GET request
$ch = curl_init();

// Set cURL options for the GET request
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


 $response = curl_exec($ch);


if(empty ($response)){
	$timer=10;
if(empty ($timer)){
	}else{
		for($time=$timer;$time>-1;$time--){
echo "\r".str_repeat(" ",30)." \r\r";
echo "\r[+] captcha retry ".$time." seconds \r";
sleep(1);
}
		}
	goto f;
	}

// Close cURL session for the GET request
curl_close($ch);
$url = "https://earnbitmoon.club/system/libs/captcha/request.php";

// Define a new boundary for multipart/form-data
$new_boundary = "----NewBoundaryString123";

// Prepare the payload with the current timestamp
$payload = [
    "i" => 1,
    "x" => 148,
    "y" => 25,
    "w" => 314.792,
    "a" => 2,
    "ts" => round(microtime(true) * 1000)  // Current timestamp in milliseconds
];

// Convert the payload to JSON and then to Base64
$payload_json = json_encode($payload);
 $payload_base64 = base64_encode($payload_json);


// Construct the multipart body
$body = "--$new_boundary\r\n";
$body .= "Content-Disposition: form-data; name=\"payload\"\r\n\r\n";
$body .= "$payload_base64\r\n";
$body .= "--$new_boundary--\r\n";

// Initialize cURL session for the POST request
$ch = curl_init($url);

// Set cURL options for the POST request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: earnbitmoon.club",
    "sec-ch-ua-platform: \"Android\"",
    "x-requested-with: XMLHttpRequest",
    "user-agent: $user_agent",
    "sec-ch-ua: \"Android WebView\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?1",
    "accept: */*",
    "origin: https://earnbitmoon.club",
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://earnbitmoon.club/",
    "accept-language: en-BD,en-US;q=0.9,en;q=0.8",
    "Content-Type: multipart/form-data; boundary=$new_boundary",
    "cookie: $cookie"
]);

// Set the request body for the POST request
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
$response = curl_exec($ch);
$st=curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($st=="400"){
	echo "\r captcha slove error      \r";
 	goto a;}else if ($st=="200"){
 echo "\r captcha slove success \r";
 $current_time = strtotime($ntime); 
$file = file("nct"); 

if (empty($file)) {
    
} else {
    // Extract the first line from the file and trim any whitespace
    $next_claim_time_str = trim($file[0]);
    $next_claim_time = strtotime($next_claim_time_str); // Convert the claim time to timestamp

    // Calculate the difference in seconds
    $remaining_seconds = $next_claim_time - $current_time;

    // Conditional logic based on remaining time
    if ($remaining_seconds > 0) {
        $timer = $remaining_seconds ;// Limit countdown to 270 seconds
                for ($time = $timer; $time > -1; $time--) {
            echo "\r[+] wait " . $time . " seconds \r";
            sleep(1); 
        }
        
    } else {
    
    }


   
}
 
 
 
 
 
 }

$url='https://earnbitmoon.club/system/ajax.php';
curl_close($ch);
$ch = curl_init($url);
$data="a=getFaucet&token=$tk&captcha=3&challenge=false&response=false&ic-hf-id=1&ic-hf-se=148%2C25%2C314.792&ic-hf-hp=";
// Set cURL options for the POST request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: earnbitmoon.club",
    "sec-ch-ua-platform: \"Android\"",
    "x-requested-with: XMLHttpRequest",
    "user-agent: $user_agent",
    "sec-ch-ua: \"Android WebView\";v=\"131\", \"Chromium\";v=\"131\", \"Not_A Brand\";v=\"24\"",
    "sec-ch-ua-mobile: ?1",
    "accept: */*",
    "origin: https://earnbitmoon.club",
    "sec-fetch-site: same-origin",
    "sec-fetch-mode: cors",
    "sec-fetch-dest: empty",
    "referer: https://earnbitmoon.club/",
    "accept-language: en-BD,en-US;q=0.9,en;q=0.8",
    "cookie: $cookie"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 $response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error on POST: ' . curl_error($ch);
    goto a;
} else {
	}
 
$json= json_decode($response);
 $status=$json->status;
 $number=$json->number;
 $reward=$json->reward;
 
if($status=="200"){
	
	
	$ntime = time();
 $next_claim = $ntime + 297;
 $nct= date('H:i:s', $next_claim);
 $txt="$nct";
	$file=fopen("nct","w");
  fwrite($file,$txt);
  
 $url="https://earnbitmoon.club";
 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $h1);
$response = curl_exec($ch);
$ntime = date('H:i:s');
$tk =trim(explode("'", explode("var token = '", $response)[1])[0]);
 $ba=explode('<',explode('text-primary"><b id="sidebarCoins">',$response)[1])[0];
	echo " $ntime | number $number | reward $reward | balance $ba \n";
$ba = str_replace(',', '', $ba); // Remove commas to handle numeric comparison
$ba = (float) $ba; // Cast to float for comparison

if ($ba > $withd_amount) {
	$bal="$withd_amount";
withdrawal($tk,$bal);

}

 	goto f;
}else{

goto f;
}

?>

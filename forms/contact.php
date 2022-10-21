<?php
if($_POST)
{
	 $to_Email   	= 'info@impeccablewritings.com'; //Replace with recipient email address
	$subject        = 'Gocargo | Quote  inquiry'; //Subject line for emails
	//check $_POST vars are set, exit if any missing
	if(!isset($_POST["name"]))
	{
		$data = array('error' => true ,'message' => 'Input fields are empty!');
        echo json_encode($data); 
		die();
	}

	//Sanitize input data using PHP filter_var().
	$user_Name        = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$user_phone     = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
	$user_Message     = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
	
	
	
    
    $boundary = md5("sanwebe");
  
	
	if(strlen($user_Message)<5) //check emtpy message
	{
		$data = array('error' => true ,'message' => 'Too short message! Please enter something.');
        echo json_encode($data); 
		die();
	}
	$message = '
<table class="table table-bordered" style="border: 1px solid #000;">
      <thead>
        <tr>
          <th></th>
          <th></th>
          
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border-right: 1px solid #ddd;">Name :</td>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$user_Name .'</td>
          
        </tr>
        
        <tr>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border-right: 1px solid #ddd;">Phone Number :</td>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$user_phone .'</td>
          
        </tr>
        
       <tr>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border-right: 1px solid #ddd;">Message Number :</td>
          <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;">'.$user_Message .'</td>
          
        </tr>
        
        
        
       
      </tbody>
    </table>';
	
	 if($file_error>0)
    {
        die('upload error');
    }
    //read from the uploaded file & base64_encode content for the mail
   


        $boundary = md5("sanwebe"); 
        //header
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "From:".$user_Email."\r\n"; 
        $headers .= "Reply-To: ".$user_Email."" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        
        //plain text 
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
        $body .= chunk_split(base64_encode($message)); 
        
        //attachment
        $body .= "--$boundary\r\n";
        $body .="Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .="Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .="Content-Transfer-Encoding: base64\r\n";
        $body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
        $body .= $encoded_content; 
    
    $sentMail = @mail($to_Email, $subject, $body, $headers);
    if($sentMail) //output success or failure messages
    {       
        $data = array('ok' => true ,'text' => 'Message Sent! We will get back soon.');
        echo json_encode($data);
    }else{
    	 $data = array('error' => true ,'message' => 'Could not send mail! Please check your PHP mail configuration.');
        echo json_encode($data);  
    }
}



?>
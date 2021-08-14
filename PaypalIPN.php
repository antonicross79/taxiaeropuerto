<?php

class PaypalIPN
{
    /** @var bool Indicates if the sandbox endpoint is used. */
    private $use_sandbox = false;
    /** @var bool Indicates if the local certificates are used. */
    private $use_local_certs = false;

    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';

    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public function useSandbox()
    {
        $this->use_sandbox = true;
    }

    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = true;
    }

    /**
     * Determine endpoint to post the verification data to.
     *
     * @return string
     */
    public function getPaypalUri()
    {
        if ($this->use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }
    
    public function sockVerifyIPN(){
        $resp = 'cmd=_notify-validate';
        foreach ($_POST as $parm => $var) 
    	{
        	$var = urlencode(stripslashes($var));
        	$resp .= "&$parm=$var";
    	}
    	$httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";
        
        $fh = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

        // STEP 5 - Nearly done.  Now send the data back to PayPal so it can tell us if the IPN notification was genuine
         
         if (!$fh) {
         
        // Uh oh. This means that we have not been able to get thru to the PayPal server.  It's an HTTP failure
        throw new Exception("Cannot create SSL connection with PayPal");
        // You need to handle this here according to your preferred business logic.  An email, a log message, a trip to the pub..
       } 
        		   
        // Connection opened, so spit back the response and get PayPal's view whether it was an authentic notification		   
        		   
        else 	{
                   fputs ($fh, $httphead . $resp);
        		   while (!feof($fh))
        				{
        				$readresp = fgets ($fh, 1024);
        				if (strcmp ($readresp, "VERIFIED") == 0) 
        					{
        					    return true;
         
        // 				Hurrah. Payment notification was both genuine and verified
        //
        //				Now this is where we record a record such that when our client gets returned to our success.php page (which might be momentarily
        //  			(remember, PayPal tries to stall users for 10 seconds after purchase so the IPN gets through first) or much later, we can see if the
        //				payment completed; and if it did, we can release the download.  You can go about this synchronisation between listener.php
        //				and success.php in many different ways.  How you do it mostly depends on your need for security; but here is one way I do it:
        //
        //				When the client initiates the purchase by clicking the "buy" button, I write a new "unconfirmed" payment record in my Payments
        //				table; this includes all the details of what they wish to purchase and their session-ID.  I then pass the record "id" of this pending entry in the CUSTOM
        //				parameter to PayPal when it processes my site visitor tranaction.
        //
        //				After PayPal processes the transation, it doesn't return the client to your site immediately; it conveniently stalls them for around
        //				10 seconds, during which it quickly calls your listener program (this program) to give it the good news.  I then extract the record_id
        //				that was inserted in the Payments table database that was created just before the client was sent to PayPal, but now I know that
        //				the payment is VERIFIED, so I can update the record in the PAYMENTS table from "Pending" to "Completed".
        //
        //				When (or if) the user returns to my "Auto Return" success.php page, I query the database for all "Completed" transactions with the
        //				same Session_id, read the digital products that they have purchased and then release them as downloadable links in
        //				success.php.
        //
        //				Yes, session_id is not totally reliable, but you could use cookies, or you could use a comprehensive user
        //				registration, logon & password retrieval system that would give you the degree of "lock down" you require.  Your choice.
        //
        					}
         
        				else if (strcmp ($readresp, "INVALID") == 0) 
        					{
         
        //  			Man alive!  A hacking attempt?
                            return false;
        					}
        				}
        fclose ($fh);
        		}
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verifyIPN()
    {
        if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . "/cert/cacert.pem");
            curl_setopt($ch, CURLOPT_CAPATH, __DIR__ . "/cert/cacert.pem");
            curl_setopt($ch, CURLOPT_CERTINFO, 1);
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }
        
        $info = curl_getinfo($ch);
        ob_start();
        var_dump($info);
        $resultString = ob_get_clean();
        $http_code = $info['http_code'];
        if ($http_code != 200) {
            throw new Exception("PayPal responded with http code $http_code, $resultString");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        if ($res == self::VALID) {
            return true;
        } else {
            return false;
        }
    }
}
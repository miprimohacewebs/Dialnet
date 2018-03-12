<?php
function sendAuthorizedRequest($url) {

    ///// Configuración de la API
    $client_id = 5300;
    $client_secret = 'xwOkltuHd4I2Le5Y';
    $callback_url = 'https://homestead.test';
    ///// FIN Configuración


    global $headers;
    $headers = array();
    session_start();
    $access_token = session('access_token');

    if ($access_token===null) {
        $callback_url = $callback_url.'?vueltaMendeley=true';
        if (!isset($_GET['vueltaMendeley'])) {
            $auth_url = "https://api.mendeley.com/oauth/authorize?client_id=$client_id&client_secret=$client_secret&response_type=code&scope=all&redirect_uri=" . urlencode($callback_url);
            redirect2($auth_url);
            exit;
        }else{
            if (isset($_GET['code'])) {
                $curl = curl_init('https://api.mendeley.com/oauth/token');
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code='.urlencode($_GET['code']).'&redirect_uri='.urlencode($callback_url));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // basic authentication ...
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($curl, CURLOPT_USERPWD, $client_id . ':' . $client_secret);
                $auth = curl_exec($curl);
                if ($auth === false) {
                    $auth = curl_error($curl);
                    $access_token = null;
                } else {
                    $secret = json_decode($auth);
                    $access_token = $secret->access_token;
                }

                if (($access_token != null) && strlen("$access_token")>0) {
                    session('access_token', $access_token);
                    $expires_in = $secret->expires_in;
                    session('expires', time()+(integer)$expires_in);
                    session('refresh_token', $secret->refresh_token);
                    redirect2('https://homestead.test');
                    exit;
                }
            }
        }
    } else {
        dd($access_token);
        // OAuth2

        $expires_at = session('expires');;
        if ($expires_at < (time() - 200)) {
            // retrieve new authorization token
            $curl = curl_init('https://api.mendeley.com/oauth/token');
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=refresh_token&refresh_token=' . urlencode(session('refresh_token')) . '&redirect_uri=' . urlencode($callback_url));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // basic authentication ...
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $client_id . ':' . $client_secret);
            $auth = curl_exec($curl);
            if ($auth === false) {
                $auth = curl_error($curl);
                $access_token = null;
            } else {
                $secret = json_decode($auth);
                $access_token = $secret->access_token;
            }
            if (($access_token != null) && strlen("$access_token") > 0) {
                session('access_token', $access_token);
                $expires_in = $secret->expires_in;
                session('expires', time()+(integer)$expires_in);
                session('refresh_token', $secret->refresh_token);
                echo "<p>Successfully refreshed access token ...</p>";
            } else {
                ?>
                <div class="updated"><p>
                        <strong><?php _e("Failed refreshing OAuth2 access token: $auth", "MendeleyPlugin"); ?></strong>
                    </p></div>
                <?php
            }
        }

        if (!(strpos($url, 'https://api.mendeley.com/') === 0)) {
            $url = 'https://api.mendeley.com/' . $url;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token, 'User-Agent: CURL'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        // send request
        if ($this->settings['debug'] === 'true') {
            echo "<p>Request: ".$url."</p>";
        }
        $resp = curl_exec($curl);
        if ($resp === false) {
            echo "<p>Mendeley Plugin Error: Failed accessing Mendeley API: " . curl_error($curl) . "</p>";
            return null;
        }
        if ($this->settings['debug'] === 'true') {
            echo "<p>Response: ".$resp."</p>";
        }
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_size);
        dd($resp);
        $body = substr($resp, $header_size);
        // parse headers
        foreach (explode("\r\n", $header) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);
                if ($key === "Link") {
                    $pos1 = strpos($value, "rel=");
                    if ($pos1) {
                        $pos2 = strpos($value, "\"", $pos1+6);
                        $tmps = substr($value, $pos1+5, $pos2-$pos1-5);
                        $key = $key . "-" . $tmps;
                    }
                    $pos1 = strpos($value, "<");
                    $pos2 = strpos($value, ">");
                    $tmps = substr($value, $pos1+1, $pos2-$pos1-1);
                    $value = $tmps;
                }
                $headers[$key] = $value;
            }
        }
    }
    $result = json_decode($body);

    if (!is_null($result->error)) {
        echo "<p>Mendeley Plugin Error: Got return code " . $result->error . " when trying to access Mendeley API</p>";
        $error_message = $result->error;
    }
    return $result;
}

function redirect2($url){
    if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header('Location: '.$url); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}//==== End -- Redirect
?>
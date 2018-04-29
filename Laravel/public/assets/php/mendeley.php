<?php
function sendAuthorizedRequest($url) {

    ///// Configuración de la API
    $client_id = 5300;
    $client_secret = 'xwOkltuHd4I2Le5Y';
    $callback_url = 'https://homestead.test';
    ///// FIN Configuración


    global $headers;
    $headers = array();
    $access_token = null;
    if (isset($_COOKIE['access_token'])) {
        $access_token = $_COOKIE['access_token'];
    }
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
                    setcookie('access_token', $access_token);
                    $expires_in = $secret->expires_in;
                    setcookie('expires', time()+(integer)$expires_in);
                    setcookie('refresh_token', $secret->refresh_token);
                    redirect2('https://homestead.test');
                    exit;
                }
            }
        }
    } else {
        // OAuth2
        $expires_at =  $_COOKIE['expires'];
        if ($expires_at < (time() - 200)) {
            // retrieve new authorization token
            $curl = curl_init('https://api.mendeley.com/oauth/token');
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=refresh_token&refresh_token=' . urlencode( $_COOKIE['refresh_token']) . '&redirect_uri=' . urlencode($callback_url));
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
                setcookie('access_token', $access_token);
                $expires_in = $secret->expires_in;
                setcookie('expires', time()+(integer)$expires_in);
                setcookie('refresh_token', $secret->refresh_token);
                redirect2('https://homestead.test');
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
        $resp = curl_exec($curl);
        if ($resp === false) {
            return null;
        }
        dd($resp);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($resp, 0, $header_size);
        $body = substr($resp, $header_size);
        // parse headers
        foreach (explode("\r\n", $header) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                if ($i!==8 && $i!==9){
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
    }
    dd($body);
    $result = json_decode($body);
    if (!empty($result)){
        if (!is_null($result->error)) {

            $error_message = $result->error;
        }
    }

    dd($result);
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
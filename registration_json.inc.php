<?php



$data = array("value" => "Pooshposh65");
$data_string = json_encode($data);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://crowd.cip4.org/crowd/rest/usermanagement/latest/authentication?username=w.tanner');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($data_string),
'Accept: application/json'
)
);

curl_setopt($ch, CURLOPT_USERPWD, 'registration-connect:cip458wJT');

$output = curl_exec($ch);

echo $output;

curl_close($ch);

class User_Registration {

    public $captcha_sitekey = '6LcTcj8UAAAAAOgeonaqGTEU-SbD7sjI7q4nwtKy';
    private $captcha_secretkey = '6LcTcj8UAAAAAKR6lYdPirR4vHIt_HOTbZsf-rKp';
    private $error_message_list = array();
    private $success_message_list = array();

    private $user_group = "cip4_visitor";
    // Definitions of the different urls required for json functions
    private $authenticate_url = 'https://crowd.cip4.org/crowd/rest/usermanagement/latest/authentication?username=w.tanner';
    private $save_user_url = ' https://crowd.cip4.org/crowd/rest/usermanagement/latest/user';
    private $save_user_group_url = 'https://crowd.cip4.org/crowd/rest/usermanagement/latest/user/group/direct?username=test.user';

// functions
    public function _create_ssha_password($password) {
        mt_srand((double) microtime() * 1000000);
        $salt = mhash_keygen_s2k(MHASH_SHA1, $password, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
        $hash = "{SSHA}" . base64_encode(mhash(MHASH_SHA1, $password . $salt) . $salt);
        return $hash;
    }

    private function _login_already_exists_in_ldap($login) {
        $group_member = $this->_get_visitor_ldap_groupmember();
        if(array_search($login, $group_member, true)) {
            return true;
        }
        $users = $this->_get_existing_ldap_users();
        if(array_search($login, $users, true)) {
            return true;
        }
        return false;
    }

    private function _save_request_to_database($send_data, $user_hash) {
        $query = $this->database_handler->prepare("REPLACE INTO user_requests SET login = :login, email = :email, firstname = :firstname, lastname = :lastname, password = :password, user_hash = :user_hash");

        $result = $query->execute(array(
            ':login' => strtolower($send_data['login']),
            ':email' => $send_data['emailaddress'],
            ':firstname' => $send_data['firstname'],
            ':lastname' => $send_data['lastname'],
            ':password' => $this->_create_ssha_password($send_data['password']),
            ':user_hash' => $user_hash,
        ));
        return $result ? true : false;
    }

    private function _validate_form_data($send_data) {
        $result = array(
            'success'		=> true,
            'message_list'	=> array()
        );
        $validate = array(
            'login'				=> 'fill in your login',
            'emailaddress'		=> 'fill in your email address',
            'firstname'			=> 'fill in your last name',
            'lastname'			=> 'fill in your first name',
            'password'			=> 'choose a password',
            'reenter_password'	=> 'reenter the choosen password',
        );
        foreach($validate as $key => $text) {
            if(!array_key_exists($key, $send_data) || $send_data[$key] == '') {
                array_push($result['message_list'], 'please ' . $text);
                $result['success'] = false;
            }
        }

        if($send_data['password'] != $send_data['reenter_password']) {
            array_push($result['message_list'], 'the choosen password and the reentered password are nor the same');
            $result['success'] = false;
        } else if($send_data['password'] && strlen($send_data['password']) < 8) {
            array_push($result['message_list'], 'please choose a password with more than 7 characters');
            $result['success'] = false;
        }

        if($send_data['emailaddress'] && !filter_var($send_data['emailaddress'], FILTER_VALIDATE_EMAIL)) {
            array_push($result['message_list'], 'please enter a valid email address');
            $result['success'] = false;
        }

        return $result;
    }
private function _verify_recaptcha2()
{
    $sender_name = stripslashes($_POST["sender_name"]);
    $sender_email = stripslashes($_POST["sender_email"]);
    $sender_message = stripslashes($_POST["sender_message"]);
    $response = $_POST["g-recaptcha-response"];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LcTcj8UAAAAAKR6lYdPirR4vHIt_HOTbZsf-rKp',
        'response' => $_POST["g-recaptcha-response"]
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    if ($captcha_success->success == false) {
        echo "<p>You are a bot! Go away!</p>";
    } else if ($captcha_success->success == true) {
        echo "<p>You are not not a bot!</p>";
    }
}
}
<?php
require_once('./lib/register.inc.php');
$OLD_CONTENT = array();
$VALIDATION_PERFORMED = false;
$SUBMIT_PERFORMED = false;
$SUCCESS = true;
$MESSAGE_CONTENT = "";

$register = new Local_Registration(array(
    'captcha_private_key'	=> "6Lfz2_4SAAAAANgDXwpK1t5u70agv7x3uhyoIKtT",
    'captcha_public_key'	=> "6Lfz2_4SAAAAAHlReuo0WAhFou1tdx7vCo53eI39",
));

$OLD_CONTENT = $register->parse_websave_content($_POST);
if($register->init()) {
    if($register->is_validation_request($_GET)) {
        $VALIDATION_PERFORMED = true;
        if($register->save_validated_user($_GET)) {
            $SUCCESS = true;
        } else {
            $SUCCESS = false;
        }
    } else if($register->form_was_submitted($_POST)) {
        $SUBMIT_PERFORMED = true;
        if($register->save_user_request($_POST)) {
            $SUCCESS = true;
        } else {
            $SUCCESS = false;
        }
    }
}
foreach($register->get_error_messages() as $message) {
    $MESSAGE_CONTENT .= '<div class="alert alert-danger" role="alert">';
    $MESSAGE_CONTENT .= $message;
    $MESSAGE_CONTENT .= '</div>';
}
foreach($register->get_success_messages() as $message) {
    $MESSAGE_CONTENT .= '<div class="alert alert-success" role="alert">';
    $MESSAGE_CONTENT .= $message;
    $MESSAGE_CONTENT .= '</div>';
}
$register->end();
?>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <!--link rel="stylesheet" href="./lib/bootstrap.min.css"-->
    <link rel="stylesheet" href="style_json.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="./lib/html5shiv.min.js"></script>
    <script src="./lib/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var RecaptchaOptions = {
            theme: 'white',
            tabindex: 7,
            lang: 'en',
            custom_translations : { instructions_visual : "Type the words above:" }
        };
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="container">
    <?php
    if($VALIDATION_PERFORMED) {
        include('./lib/validation_success.html.inc.php');
    } else if($SUBMIT_PERFORMED && $SUCCESS) {
        include('./lib/submit_success.html.inc.php');
    } else {
        include('./lib/form.html.inc.php');
    }
    ?>
</div>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: cip4
 * Date: 05/01/18
 * Time: 14:13
 */
// constructing base urls for json requests: want to take different parts and put them together to make a url
$username = 'test.user';
$protocol = 'https';
$base_url = 'crowd.cip4.org/crowd/rest/usermanagement/latest/';
$authent_base = 'authentication?username';
$authent_url = $protocol . '://' . $base_url . $authent_base .'=' . $username;

echo $authent_url;

<?php
function randString($length = 50)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function set_csrf($len = 80)
{
    $token = randString($len);
    $_SESSION['_token'] = $token;
    return $token;
}

function get_csrf()
{
    if (isset($_SESSION['used_token']) && $_SESSION['used_token'] == 1)
        set_csrf();

    $_SESSION['used_token'] = 0;
    return isset($_SESSION['_token']) ? $_SESSION['_token'] : set_csrf();
}

function check_csrf($token)
{

    if (isset($_SESSION['_token']) && $token == $_SESSION['_token']) {
        $_SESSION['used_token'] = 1;
        return true;
    }
    return false;
}

function auth()
{
    if (isset($_SESSION['user'])) {
        return true;
    }
    return false;
}

function logout()
{
    session_destroy();
    die("<pre>   <br> Thanks, you have logged out, <a href='index.php'>Home</a> </pre>");
}

function expired_page()
{
    die("<pre>   <br>    expired page. <a href='index.php'>Home</a> </pre>");
}

function e_message($token)
{
    $cipher_method = 'AES-128-CTR';
    $enc_key = openssl_digest(__KEY__, 'SHA256', TRUE);
    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
    return openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

}

function d_message($crypted_token)
{
    list($crypted_token, $enc_iv) = explode("::", $crypted_token);;
    $cipher_method = 'AES-128-CTR';
    $enc_key = openssl_digest(__KEY__, 'SHA256', TRUE);
    return openssl_decrypt($crypted_token, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
}

function showMessagePage()
{
    global $db;
    $usersModel = new users($db->connection());
    $users = $usersModel->getUsers();

    $messenger = new messages($db->connection());
    $messages = $messenger->getMessages($_SESSION['user']['id']);
    require('../temp/messages.php');
    die();
}

function viewMessages($messages)
{
    $text = "<table>
                <tbody>
                <tr>
                    <td colspan='2'>id </td><td colspan='2'>sender</td><td colspan='5'>message</td>
                </tr>";

    foreach ($messages as $message)
        $text .= '<tr>
                    <td colspan="2">'.$message['id'].'</td>
                    <td colspan="2">'.$message['sender_name'].'</td>
                    <td colspan="2">'. d_message($message['message']).'</td>
                   </tr>';

    return "</tbody></table>".$text;
}

function pre($var)
{
    echo "<pre>";
    var_dump($var);
    echo "<hr>";
}

function forceDownload($filename, $type = "application/octet-stream") {
    header('Content-Type: '.$type.'; charset=utf-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
}

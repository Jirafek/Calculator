<?

class EmailCode {
    static public function create($data) {
        $data = protectionData($data);
        $data = json_decode($data, true);

        $email = $data['email'];

        $email = protectionData($email);

        $_SESSION['confirm']['email'] = $email;
        $_SESSION['confirm']['code'] = random_int(10000, 99999);

        $to      = "$email";
        $subject = 'Восстановление пароля';
        $message = 'hello';
        $headers = 'From: webmaster@example.com'       . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    static public function confirm($email, $code) {
        $state = true;

        if ($_SESSION['confirm']['email'] !== $email) {
            $state = false;
        }

        if ($_SESSION['confirm']['code'] !== $code) {
            $state = false;
        }

        return $state;
    }
}

?>
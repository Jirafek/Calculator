<?

class EmailCode {
    static public function create($data) {
        $data = protectionData($data);
        $data = json_decode($data, true);

        $email = $data['email'];

        $email = protectionData($email);

        setcookie('email_code', random_int(10000, 99999), time() + 60*10);

        $to      = "$email";
        $subject = 'Восстановление пароля';
        $message = 'hello';
        $headers = 'From: mail@bsspo.ru' . "\r\n" .
                    'Reply-To: mail@bsspo.ru' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    static public function confirm($email, $code) {
        $state = true;

        if ($_COOKIE['email_code'] !== $email) {
            $state = false;
        }

        if ($_COOKIE['email_code'] !== $code) {
            $state = false;
        }

        return $state;
    }
}

?>
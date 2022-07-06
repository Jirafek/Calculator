<?

class EmailCode {
    static public function create($data) {
        $data = protectionData($data);
        $data = json_decode($data, true);

        $email = $data['email'];

        $_SESSION['confirm']['email'] = $email;
        $_SESSION['confirm']['code'] = random_int(10000, 99999);
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
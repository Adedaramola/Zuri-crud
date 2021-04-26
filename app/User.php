<?php

class User
{
    private $db;

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $confirmPassword;
    public $created_at;

    public $error = [
        'firstname' => '',
        'lastname' => '',
        'email' => '',
        'password' => '',
        'confirm' => '',
        'error' => '',
        'msg' => '',
    ];

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function register()
    {
        $this->firstname = $this->sanitize($this->firstname);
        $this->lastname = $this->sanitize($this->lastname);
        $this->email = $this->sanitize($this->email);
        $this->password = $this->sanitize($this->password);
        $this->confirmPassword = $this->sanitize($this->confirmPassword);

        if (empty($this->firstname)) {
            $this->error['firstname'] = 'Firstname is required';
        }

        if (empty($this->lastname)) {
            $this->error['lastname'] = 'Lastname is required';
        }

        if (empty($this->email)) {
            $this->error['email'] = 'Email address is required';
        } elseif (!$this->isEmailValid($this->email)) {
            $this->error['email'] = 'Invalid email address';
        } else {
            if ($this->emailExists($this->email)) {
                $this->error['email'] = 'Account with this email exists already';
            }
        }

        if (empty($this->password)) {
            $this->error['password'] = 'Password is required';
        } elseif (strlen($this->password) < 8 || strlen($this->password) > 16) {
            $this->error['password'] = 'Password must be 8-16 characters';
        }

        if ($this->confirmPassword != $this->password) {
            $this->error['confirm'] = 'Passwords do not match';
        }

        if (empty($this->error['firstname']) && empty($this->error['lastname']) && empty($this->error['email']) && empty($this->error['password']) && empty($this->error['confirm'])) {

            $this->db->query('INSERT INTO users (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)');

            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $this->db->bind(':firstname', $this->firstname);
            $this->db->bind(':lastname', $this->lastname);
            $this->db->bind(':email', $this->email);
            $this->db->bind(':password', $hashPassword);

            if ($this->db->execute()) {
                return true;
            }

            return false;
        }
    }

    public function login()
    {
        $this->email = $this->sanitize($this->email);
        $this->password = $this->sanitize($this->password);

        if (empty($this->email)) {
            $this->error['email'] = 'Email address is required';
        } elseif (!$this->isEmailValid($this->email)) {
            $this->error['email'] = 'Invalid email address';
        }

        if (empty($this->password)) {
            $this->error['password'] = 'Password is required';
        }

        if (empty($this->error['email']) && empty($this->error['password'])) {

            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $this->email);
            $result = $this->db->single();

            if ($result) {
                $verifyPassword = $result->password;
                if (password_verify($this->password, $verifyPassword)) {
                    return $result;
                } else {
                    $this->error['error'] = 'Invalid password';
                }
            }
            $this->error['error'] = 'Invalid email or password';
        }
    }

    public function resetPassword()
    {
        $this->email = $this->sanitize($this->email);
        $this->password = $this->sanitize($this->password);

        if (empty($this->email)) {
            $this->error['email'] = 'Email address is required';
        } elseif (!$this->isEmailValid($this->email)) {
            $this->error['email'] = 'Invalid email address';
        }

        if (empty($this->password)) {
            $this->error['password'] = 'Password is required';
        }

        if ($this->confirmPassword != $this->password) {
            $this->error['confirm'] = 'Passwords do not match';
        }

        if (empty($this->error['email']) && empty($this->error['password']) && empty($this->error['confirm'])) {

            if (!$this->emailExists($this->email)) {
                $this->error['email'] = 'Account not found';
                return;
            }

            $this->db->query('UPDATE users SET password = :password WHERE email = :email');
            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $this->db->bind(':password', $hashPassword);
            $this->db->bind(':email', $this->email);
            if ($this->db->execute()) {
                return true;
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['message']);
        session_destroy();
        header('Location: auth/login.php');
    }

    private function isEmailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function emailExists($email)
    {
        $this->db->query('SELECT id FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        $result = $this->db->rowCount();
        if ($result > 0) {
            return true;
        }
        return false;
    }

    private function sanitize($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}

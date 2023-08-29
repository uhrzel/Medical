<?php

class User extends Model{
    public function __construct(){
        parent::__construct('tbl_users', 'user_id');
    }

    public function AdminLogin($username, $password){
        $admin = $this->find([
            'conditions' => 'user_name = ? AND user_password = ? AND user_roles = ?',
            'bind' => [$username, $password, 'admin']
        ]);

        if($admin){
            return $admin[0]->user_id;
        }
    }

    public function DoctorLogin($username, $password){
        $doctor = $this->find([
            'conditions' => 'user_name = ? AND user_roles = ?',
            'bind' => [$username, 'doctor']
        ]);

        if($doctor){
            if(password_verify($password, $doctor[0]->user_password)){
                $sessions = new Sessions();
                $sessions->create([
                    'user_id' => $doctor[0]->user_id,
                    'session_status' => 'login'
                ]);
                return $doctor[0];
            }
        }
    }

    public function PatientLogin($username, $password){
        $patient = $this->find([
            'conditions' => 'user_name = ? AND user_roles = ?',
            'bind' => [$username, 'patient']
        ]);

        if($patient){
            if(password_verify($password, $patient[0]->user_password)){
                $sessions = new Sessions();
                $sessions->create([
                    'user_id' => $patient[0]->user_id,
                    'session_status' => 'login',
                ]);
                return $patient[0];
            }
        }
    }

    public function createUser($roles, $random_password){
        $user = $this->find([
            'conditions' => 'user_name = ? OR user_email = ?',
            'bind' => [Input::get('username'), Input::get('email')]
        ]);

        if($user){
            Session::flash('error', 'Username or Email already exists');
            return false;
        }else{
            $this->create([
                'user_first_name' => Input::get('first_name'),
                'user_last_name' => Input::get('last_name'),
                'user_name' => Input::get('username'),
                'user_number' => Input::get('number'),
                'user_email' => Input::get('email'),
                'user_password' => password_hash($random_password, PASSWORD_DEFAULT),
                'user_gender' => Input::get('gender'),
                'user_roles' => $roles,
            ]);

            return $this->db->lastInsertId();
        }
    }

    public function createDoctor($random_password){
        $res =  $this->createUser('doctor', $random_password);

        if($res){
            $doctor = new Doctor();

            $doctor->create([
                'doctor_id' => $res,
                'doctor_specialization' => Input::get('specialization'),
                'doctor_clinic_address' => Input::get('clinic'),
            ]);

            return true;
        }

        return false;
    }

    public function send_email($email, $subject, $body, $otp_code){
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;                                     
            $mail->isSMTP();
            $mail->Host       = Config::get('mail/host');
            $mail->SMTPAuth   = true;
            $mail->Username   = Config::get('mail/username');
            $mail->Password   = Config::get('mail/password');
            $mail->SMTPSecure = Config::get('mail/encryption');
            $mail->Port       = Config::get('mail/port');

            $mail->setFrom(Config::get('mail/username'), Config::get('mail/from'));
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $otp_code;

            $mail->send();
        } catch (Exception $e) {
            Session::flash('error', 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
        }

        return true;

    }

    public function send_mail($email, $subject, $body){
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;                                     
            $mail->isSMTP();
            $mail->Host       = Config::get('mail/host');
            $mail->SMTPAuth   = true;
            $mail->Username   = Config::get('mail/username');
            $mail->Password   = Config::get('mail/password');
            $mail->SMTPSecure = Config::get('mail/encryption');
            $mail->Port       = Config::get('mail/port');

            $mail->setFrom(Config::get('mail/username'), Config::get('mail/from'));
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            if($mail->send()){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            Session::flash('error', 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo);
        }
    }

}
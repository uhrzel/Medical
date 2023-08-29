<?php

class Otp extends Model{
    public function __construct(){
        parent::__construct('tbl_otps', 'otp_id');
    }

    public function createOtp($user_id, $otp_code){
        $this->create([
            'user_id' => $user_id,
            'otp_code' => $otp_code,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->lastInsertId();
    }

    public function verifyOtp($user_id, $otp_code){
        $otp = $this->find([
            'conditions' => 'user_id = ? AND otp_code = ?',
            'bind' => [$user_id, $otp_code]
        ]);

        if($otp){
            return true;
        }

        return false;
    }

    public function deleteOtp($user_id){
        $this->delete([
            'conditions' => 'user_id = ?',
            'bind' => [$user_id]
        ]);
    }
}
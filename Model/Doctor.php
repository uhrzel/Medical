<?php

class Doctor extends Model{
    public function __construct(){
        parent::__construct('tbl_doctors', 'doctor_id');
    }

    public function createDoctor(){
        $user = new User();

        $random_password = rand();

        $res = $user->createUser('doctor', $random_password);

        if($res){
            $this->create([
                'doctor_id' => $user->lastInsertId(),
                'doctor_specialization' => Input::get('specialization'),
                'doctor_clinic_address' => Input::get('clinic'),
            ]);

            return true;
        }

        return false;
    }
}
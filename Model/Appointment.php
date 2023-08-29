<?php

class Appointment extends Model{
    public function __construct(){
        parent::__construct('tbl_appointments', 'appointment_id');
    }

    public function find_by_patient($patient_id){
        return $this->find([
            'conditions' => 'patient_id = ?',
            'bind' => [$patient_id]
        ]);
    }

    public function find_by_doctor($doctor_id){
        return $this->find([
            'conditions' => 'doctor_id = ?',
            'bind' => [$doctor_id]
        ]);
    }

    public function find_by_doctor_and_patient($doctor_id, $patient_id){
        return $this->find([
            'conditions' => 'doctor_id = ? AND patient_id = ?',
            'bind' => [$doctor_id, $patient_id]
        ]);
    }
}
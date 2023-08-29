<?php

class Patientes extends Model{
    public function __construct(){
        parent::__construct('tbl_patients', 'patient_id');
    }
}
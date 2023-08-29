<?php

class Medical extends Model{
    public function __construct(){
        parent::__construct('tbl_medicals', 'medical_id');
    }
}
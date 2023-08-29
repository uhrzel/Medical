<?php

class Sessions extends Model{
    public function __construct(){
        parent::__construct('tbl_sessions', 'session_id');
    }
}
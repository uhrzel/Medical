<?php

require('../Autoload.php');

if(!isset($_GET['table']) || !isset($_GET['id']) || !is_numeric($_GET['id'])){
    Session::flash('error', 'Invalid request');
    Redirect::to('index.php?page=dashboard');
}

try{
    switch($_GET['table']){
        case 'users':
            $user = new User();
            $user->delete($_GET['id']);
            Session::flash('success', 'User deleted successfully');
            Redirect::to('index.php?page=dashboard');
            break;

        case 'appointments':
            $appointment = new Appointment();
            $appointment->delete($_GET['id']);
            Session::flash('success', 'Appointment deleted successfully');
            Redirect::to('index.php?page=appointments');
            break;

        default:
            Session::flash('error', 'Invalid table name');
            Redirect::to('index.php?page=dashboard');
            break;
    }
}catch(Exception $e){
    Session::flash('error', $e->getMessage());
    header('Location: index.php?page=dashboard');
    exit;
}
<?php

if(!isset($_POST['set_fee'])){Redirect::to('index.php?page=dashboard');}

$validate = new Validate();

$validation = $validate->check($_POST, [
    'appointment_id' => [
        'display' => 'Appointment ID',
        'required' => true,
    ],
    'appointment_consultancy_fee' => [
        'display' => 'Consultancy Fee',
        'required' => true,
    ],
]);

if($validation->passed()){
    $appointment = new Appointment();
    $a = $appointment->find([
        'conditions' => 'appointment_id = ?',
        'bind' => [Input::get('appointment_id')],
    ])[0];

    if($a){
        $appointment->update(Input::get('appointment_id'), [
            'appointment_consultancy_fee' => Input::get('appointment_consultancy_fee'),
            'appointment_status' => 'Decided',
        ]);

        Session::put('success', 'Consultancy fee set successfully');
        echo '<script>window.location.href = "index.php?page=dashboard";</script>';
    }else{
        Session::put('error', 'Appointment not found');
        echo '<script>window.location.href = "index.php?page=dashboard";</script>';
    }
}else{
    Session::put('error', $validation->errors()[0]);
    echo '<script>window.location.href = "index.php?page=dashboard";</script>';
}
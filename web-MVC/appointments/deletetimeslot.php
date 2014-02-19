<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url() . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';
require_once models_url() . 'AppointmentModel.php';

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < LECTURER)
    redirect('appointments/view.php');

if(!isset($_GET['appointmentid']))
    redirect('');

if(!isset($_GET['appointmentslotid']))
    redirect('');

$appointment = loadAppointment($_GET['appointmentid']);
if($appointment == FALSE)
    redirect('');

deleteTimeSlotAppointment($_GET['appointmentslotid']);
redirect('appointments/edit.php?appointmentid=' . $_GET['appointmentid']);
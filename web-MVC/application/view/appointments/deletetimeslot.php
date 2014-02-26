<?php

$appointment = loadAppointment($_GET['appointmentid']);
if($appointment == FALSE)
    redirect('');

deleteTimeSlotAppointment($_GET['appointmentslotid']);
redirect('appointments/edit.php?appointmentid=' . $_GET['appointmentid']);
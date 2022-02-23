<?php
require_once __DIR__ . "/../components/admin.php";

$id = request('id');



$name = request('name');
$total_seats = request('total_seats');

if (empty($id)) {
    die("Please provide ID");
}

$hall = find('hall', $id);
if (empty($hall)) {
    die("hall not found!");
}

if (empty($name)) {
    setError("Please provide Name!");
    header("Location: index.php");
    die;
}

update('hall', $id, compact('name', 'total_seats'));

setSuccess('Hall data updated!');
header("Location: index.php");

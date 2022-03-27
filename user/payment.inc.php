<?php
require "./components/user.php";

$booking_id = request('id');

$booking = query('SELECT * FROM booking where id =' . $booking_id);

if (empty($booking_id)) {
    setError('Payment Failed!!');
    header("Location: ./index.php");
}
// echo "<pre>";
// print_r($booking);
// die;
// Array
// (
//     [0] => Array
//         (
//             [id] => 53
//             [user_id] => 14
//             [show_id] => 38
//             [total_tickets] => 90
//             [unit_price] => 500
//             [status] => pending
//             [booked_seat] => 1
//             [total_price] => 500
//             [booking_time] => 2022-03-27 18:56:47
//         )

// )
$amount = $booking[0]['total_price'];


$name = request('name_on_card');

if (!validateName($name)) {
    setError("Please enter a valid name!!");
    $url = './payment.php?id=' . $booking_id;
    header("Location: $url");
    die;
}


$card = request('card_number');

if (!validateNumber($card)) {
    setError('Please Enter valid card number!!');
    $url = './payment.php?id=' . $booking_id;
    header("Location: $url");
    die;
}

$exp = request('exp_date');


$cvv = request('cvv');


if (empty($cvv)) {
    setError("Please provide all the details!!");
    $url = './payment.php?id=' . $booking_id;
    header("Location: $url");
    die;
}

if (strlen($cvv) > 3) {
    setError("Please enter valid CVV!!");
    $url = './payment.php?id=' . $booking_id;
    header("Location: $url");
    die;
}
$exists = where('payment', 'booking_id', '=', $booking_id, false);

if ($exists > 5) {
    setError("You cannot Book more than 5 seats!!");
    header("Location: ./index.php");
    die;
}

if (!empty($name) && !empty($card) && !empty($exp) && !empty($cvv)) {

    create('payment', [
        'booking_id' => $booking_id,
        'amount' => $amount,
        'payment_on' => date('Y-m-d')
    ]);

    setSuccess("Payment Successful!!");
    header("Location: ../index.php");
    die;
}

<?php

// hash password
$pwdSignup = "123456";
$options = [
    'cost' => 12
];
$hashedPwd = password_hash($pwdSignup, PASSWORD_BCRYPT, $options);

// verify password
$pwdLogin = "123456";
if (password_verify($pwdLogin, $hashedPwd)) {
    echo "The data are the same!";
} else {
    echo "The data are not the same!";
}

// // Manual hash for educational purpose
// $sensitiveData = "123456";
// $salt = bin2hex(random_bytes(16)); // generate random salt
// $pepper = "ASecretPepperString";

// $dataToHash = $sensitiveData . $salt . $pepper;
// $hash = hash("sha256", $dataToHash);

// // hash compare
// $sensitiveData = "12345678";

// $storedSalt = $salt;
// $storedHash = $hash;
// $pepper = "ASecretPepperString";

// $dataToHash = $sensitiveData . $salt . $pepper;
// $verificationHash = hash("sha256", $dataToHash);

// if ($storedHash === $verificationHash) {
//     echo "The data are the same!";
// } else {
//     echo "The data are not the same!";
// }

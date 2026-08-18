<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>

    <h1>Student Information</h1>

    <p>Student ID: <?= $student_id ?></p>
    <p>Name: <?= $name ?></p>
    <p>Course: <?= $course ?></p>
    <p>Year Level: <?= $year ?></p>
    <p>Section: <?= $section ?></p>
    <p>Email: <?= $email ?></p>

    <br>
    <a href="<?= site_url('student') ?>">Back to Home</a>

</body>
</html>
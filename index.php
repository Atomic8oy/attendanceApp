<?php // Database connection
$db = new SQLite3("database.db");

$counter = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sardaran Attendance Program</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <h1 class="header">برنامه حضور و غیاب هنرستان <!--مثلا--> نمونه سرداران شهید</h1>
    <hr>
    <form method="get">
        <div class="dropdown-container">
            <label for="base" class="dropdown-label">پایه:
                <select id="grade" name="grade" class="dropdown-select">
                    <option value="">انتخاب کنید</option>
                    <option value="10" <?php if (isset($_GET['grade']) && $_GET['grade'] == 10) { echo "selected"; } ?>>دهم</option>
                    <option value="11" <?php if (isset($_GET['grade']) && $_GET['grade'] == 11) { echo "selected"; } ?>>یازدهم</option>
                    <option value="12" <?php if (isset($_GET['grade']) && $_GET['grade'] == 12) { echo "selected"; } ?>>دوازدهم</option>
                </select>
            </label>

            <label for="base" class="dropdown-label">رشته:
                <select id="major" name="major" class="dropdown-select">
                    <option value="">انتخاب کنید</option>
                    <option value="1" <?php if (isset($_GET['major']) && $_GET['major'] == 1) { echo "selected"; } ?>>شبکه و نرم افزار رایانه</option>
                    <option value="2" <?php if (isset($_GET['major']) && $_GET['major'] == 2) { echo "selected"; } ?>>الکتروتکنیک</option>
                    <option value="3" <?php if (isset($_GET['major']) && $_GET['major'] == 3) { echo "selected"; } ?>>مکانیک خودرو</option>
                    <option value="4" <?php if (isset($_GET['major']) && $_GET['major'] == 4) { echo "selected"; } ?>>تاسیسات</option>
                </select>
            </label>
            <label class="dropdown-label"><input type="submit" class="searchSubmit" value="جستجو"></label>
        </div>
    </form>
    <hr>
    <form method="post" action="submitAction.php">
        <table class="table">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>تاخیر</th>
                    <th>غیبت ساعت اول</th>
                    <th>غیبت ساعت دوم</th>
                    <th>غیبت ساعت سوم</th>
                    <th>غیبت ساعت چهارم</th>
                    <th>غیبت کل</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (isset($_GET['grade']) && $_GET['grade'] && $_GET['major']) {
                    $grade = $_GET['grade'];
                    $major = $_GET['major'];

                    $students = $db->query("SELECT * FROM students WHERE grade='$grade' AND major='$major'");
                    while ($row = $students->fetchArray(SQLITE3_ASSOC)) {
                        $counter++;
                        $id = $row['id'];
                        $name = $row['name'];
                        echo "
                        <tr>
                            <td>$counter</td>
                            <td>$name</td>
                            <td><input name='$counter-delay' type='checkbox'></td>
                            <td><input name='$counter-i' type='checkbox'></td>
                            <td><input name='$counter-ii' type='checkbox'></td>
                            <td><input name='$counter-iii' type='checkbox'></td>
                            <td><input name='$counter-iv' type='checkbox'></td>
                            <td><input name='$counter-all' type='checkbox'></td>
                        </tr>
                        <input name='$counter-id' value='$id' hidden>"; 
                    }
                    echo "<input name='count' value='$counter' hidden>";
                }
                ?>
            </tbody>
        </table>
        <?php
        if (!$counter) {
            echo "<center><h3 class='notFound'>موردی یافت نشد!</h3></center>";
        }
        ?>
        <div class="formSubmit">
            <input class="formButton"  name="submitType" type="submit" value="ثبت" <?php if (!$counter) { echo "disabled";} ?> >
            <input class="formButton" name="submitType" type="submit" value="ثبت و ارسال پیامک" <?php if (!$counter) { echo "disabled";} ?> >
        </div>
    </form>
</body>
</html>
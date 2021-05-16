<?php 
include '../model/database.php';
$db = new Database();

$table = 'work';
$data = $db->getArray($table);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo Lists</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css -->
    <link href="../public/library/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../public/library/fontawesome-5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../public/css/style.css">
    <link href='../public/library/fullcalendar/main.css' rel='stylesheet' />

    <!-- script -->
    <script type="text/javascript" src="../public/js/jquery-3.6.0.js"></script>
    <script src="../public/library/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../public/js/app.js"></script>
    <script src='../public/library/fullcalendar/main.js'></script>
    <script src='../public/library/fullcalendar/locales-all.min.js'></script>
</head>
<body>
    <div id="listData" class="hide">
        <?php 
            if (!empty($data)) {
                foreach ($data as $key => $value) { ?>
                    <data>
                        <input class="title" value="<?php echo $value['work_name']; ?>">
                        <input class="starting-day" value="<?php echo $value['starting_day']; ?>">
                        <input class="ending-day" value="<?php echo $value['ending_day']; ?>">
                        <input class="status" value="
                            <?php 
                                switch ($value['status']) {
                                    case 'Planning':
                                        echo '#0DCAF0';
                                        break;
                                    case 'Doing':
                                        echo '#FFC107';
                                        break;
                                    case 'Complete':
                                        echo '#198754';
                                        break;
                                    default:
                                        break;
                                };
                            ?>
                        ">
                    </data>
            <?php
                }
            }
         ?>
    </div>
    <div class="container">
        <section id="header">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fas fa-clipboard-list" aria-current="page" href="../index.php"> Todo List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active fas far fa-calendar-alt" href="calendar.php"> Calendar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </section>

        <!-- Calendar -->
        <div id='calendar' class="my-3"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var initialLocaleCode = 'vi';
            var data = getDataEvent();
            var date = new Date().toISOString().slice(0, 10);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                initialDate: date,
                locale: initialLocaleCode,
                navLinks: true, // can click day/week names to navigate views
                dayMaxEvents: true, // allow "more" link when too many events
                events: data
            });

            calendar.render();
        });

        function getDataEvent() {
            var listData = document.getElementsByTagName('data');
            var data = Array();

            for(i = 0; i < listData.length; i++) {
                var title = listData[i].querySelector('.title').value.trim();
                var startingDay = listData[i].querySelector('.starting-day').value.trim();
                var endingDay = listData[i].querySelector('.ending-day').value.trim();
                var status = listData[i].querySelector('.status').value.trim();
                var dt = {
                    'title':title,
                    'start':startingDay,
                    'end':endingDay,
                    'color':status
                }

                data.push(dt);
            }
            return data;
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Glance Design Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/monthly.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">

        <!-- Nội dung chính -->
        <div class="main-page">
            <h2>Dashboard Content Here</h2>
            <p>Example content for testing scripts and layout.</p>

            <!-- Thêm phần biểu đồ và lịch -->
            <canvas id="canvas" width="400" height="200"></canvas>

            <div id="geoChart" style="width:100%;height:400px;"></div>

            <div class="calendar">
                <div id="mycalendar"></div>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <p>
                &copy; 2018 Glance Design Dashboard. All Rights Reserved |
                Design by <a href="https://w3layouts.com/" target="_blank">w3layouts</a>
            </p>
        </div>
        <!--//footer-->
    </div>

    <!-- side nav js -->
    <script src="js/SidebarNav.min.js" type="text/javascript"></script>
    <script>
        $('.sidebar-menu').SidebarNav();
    </script>
    <!-- //side nav js -->

    <!-- Geo Chart -->
    <script src="//cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
    <script>
        window.modernizr || document.write('<script src="lib/modernizr/modernizr-custom.js"><\/script>')
    </script>

    <script src="js/chartinator.js"></script>
    <script>
        jQuery(function($) {
            var chart3 = $('#geoChart').chartinator({
                tableSel: '.geoChart',
                columns: [{
                    role: 'tooltip',
                    type: 'string'
                }],
                colIndexes: [2],
                rows: [
                    ['China - 2015'],
                    ['Colombia - 2015'],
                    ['France - 2015'],
                    ['Italy - 2015'],
                    ['Japan - 2015'],
                    ['Kazakhstan - 2015'],
                    ['Mexico - 2015'],
                    ['Poland - 2015'],
                    ['Russia - 2015'],
                    ['Spain - 2015'],
                    ['Tanzania - 2015'],
                    ['Turkey - 2015']
                ],
                ignoreCol: [2],
                chartType: 'GeoChart',
                chartAspectRatio: 1.5,
                chartZoom: 1.75,
                chartOffset: [-12, 0],
                chartOptions: {
                    width: null,
                    backgroundColor: '#fff',
                    datalessRegionColor: '#F5F5F5',
                    region: 'world',
                    resolution: 'countries',
                    legend: 'none',
                    colorAxis: {
                        colors: ['#679CCA', '#337AB7']
                    },
                    tooltip: {
                        trigger: 'focus',
                        isHtml: true
                    }
                }
            });
        });
    </script>
    <!-- //Geo Chart -->

    <!-- Calendar -->
    <script src="js/monthly.js"></script>
    <script>
        $(window).load(function() {
            $('#mycalendar').monthly({
                mode: 'event'
            });

            $('#mycalendar2').monthly({
                mode: 'picker',
                target: '#mytarget',
                setWidth: '250px',
                startHidden: true,
                showTrigger: '#mytarget',
                stylePast: true,
                disablePast: true
            });

            switch (window.location.protocol) {
                case 'file:':
                    alert('Just a heads-up, events will not work when run locally.');
                    break;
            }
        });
    </script>
    <!-- //Calendar -->

    <!-- Classie --><!-- for toggle left push menu script -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        if (showLeftPush) {
            showLeftPush.onclick = function() {
                classie.toggle(this, 'active');
                classie.toggle(body, 'cbp-spmenu-push-toright');
                classie.toggle(menuLeft, 'cbp-spmenu-open');
                disableOther('showLeftPush');
            };
        }

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!-- //Classie --><!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>

    <!-- Validator JS -->
    <script src="js/validator.min.js"></script>

    <!-- Optional: thêm biểu đồ, menu mở rộng -->
    <script src="js/Chart.bundle.js"></script>
    <script src="js/utils.js"></script>

    <!-- (Nếu cần) khởi tạo biểu đồ -->
    <script>
        window.onload = function() {
            var ctx = document.getElementById('canvas');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                        datasets: [{
                            label: 'Demo Data',
                            data: [10, 20, 30, 25],
                            backgroundColor: 'rgba(54,162,235,0.5)',
                            borderColor: 'rgba(54,162,235,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            }
        };
    </script>

</body>

</html>
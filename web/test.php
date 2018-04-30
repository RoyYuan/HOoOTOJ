<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $view_title ?></title>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
    <link rel="stylesheet" type="text/css" href="css/chart.css">
</head>
<body>
<div id="test">
    <span class="chart" data-percent="40">
        <span class="percent"></span>
    </span>
</div>
<script src="js/jquery.js"></script>
<script src="js/jquery.easypiechart.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script>
    $(function() {
        $('.chart').easyPieChart({
            easing: 'easeOutBounce',
            onStep: function(from, to, percent) {
                $(this.el).find('.percent').text(Math.round(percent));
            }
        });
        var chart = window.chart = $('.chart').data('easyPieChart');
    });
</script>
</body>
</html>
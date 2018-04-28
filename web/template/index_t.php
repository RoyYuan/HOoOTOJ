<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>主页</title>
    <link rel="stylesheet" type="text/css" href="css/loginpage.css" />
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body>
<div id="C1">
    <?php require_once("header.php"); ?>
    <div id="C2">
        <center>
            <div id="main" style="width: 40%;" align="center">
                <div id="myCarousel" class="carousel slide" style="border-radius: 50px;">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                        <li data-target="#myCarousel" data-slide-to="5"></li>
                        <li data-target="#myCarousel" data-slide-to="6"></li>
                    </ol>
                    <div class="carousel-inner" style="border-radius: 50px;">
                        <div class="item active">
                            <img src="./image/slide1.jpg" alt="1">
                            <div class="carousel-caption">2015 EC-FINAL 上海</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide2.jpg" alt="2">
                            <div class="carousel-caption">2016 CCPC 湘潭</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide3.jpg" alt="3">
                            <div class="carousel-caption">2016 CCPC 长春</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide4.jpg" alt="4">
                            <div class="carousel-caption">2016 CCPC 合肥</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide5.jpg" alt="5">
                            <div class="carousel-caption">2016 ICPC 沈阳</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide6.jpg" alt="6">
                            <div class="carousel-caption">2016 ICPC 青岛</div>
                        </div>
                        <div class="item">
                            <img src="./image/slide7.jpg" alt="7">
                            <div class="carousel-caption">2016 CHINA-FINAL 上海</div>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </center>
    </div>
</div>

<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>

</html>

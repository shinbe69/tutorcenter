<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=David+Libre&family=Miriam+Libre&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/upperCSS.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/classDetailCSS.css')}}">
    <script src="{{ asset('../resources/js/upperJS.js') }}"></script>
    <script src="{{ asset('../resources/js/classDetailJS.js') }}"></script>
    <title>Tutor Center</title>
</head>
<body>
{{--    LOADING ANIMATION--}}
<div class ="wrapper">
    <div id="loading" class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
{{--UPPER LOADING EXTERNAL--}}
@include('upper')
{{--PANEL--}}
<div id="panel">
    <h3>This is the panel</h3>
</div>
{{--CONTAINER--}}
<div id="container">
    <div id="classWrapper">
        <div id="classes">
            <p class="classID">Mã lớp: {{ $class[0]['id'] }}</p>
            <hr>
            @foreach($subject as $singleSubject)
                @if($class[0]['subject'] == $singleSubject['code'])
                    <p class="subject"> &#x1F4D6; Môn: {{ $singleSubject['name'] }}</p>
                @endif
            @endforeach
            <p class="grade">Lớp: {{ $class[0]['grade'] }}</p>
            <p class="studentGender">Dạy học sinh {{ strtolower($class[0]['studentgender']) }} @if(strtolower($class[0]['studentgender']) == "nam") 👦 @else 👧 @endif</p>
            <p class="level">Học lực: {{ $class[0]['studentlevel'] }}</p>
            <p class="tuitionFee">💵 Học phí: {{ number_format($class[0]['tuitionfee']) }} VND</p>
            @php($timeArray = explode("to", $class[0]['time']))
            <p class="time"> &#x1F555; Thời gian dạy: Từ {{ $timeArray[0] }} đến {{ $timeArray[1] }}</p>
            <p class="numOfDay">🚲 Dạy {{ $class[0]['dayInAWeek'] }} buổi một tuần</p>
            <p class="reqirement"> ⚠ Yêu cầu gia sư:
                @php($requirementArray = explode(". ", $class[0]['requirements']))
                @foreach($requirementArray as $singleRequirement)
                    @if($singleRequirement == null)
                        <br> Không có
                        @break
                    @endif
                    <br> • {{ $singleRequirement }}
                @endforeach
            </p>
            <button id="takeClass">Nhận lớp ngay</button>
        </div>
    </div>
    <div id="classDetail">
        <h3>Chi tiết lớp</h3>
            @php($startTime = explode(":", $timeArray[0]))
            @php($endTime = explode(":", $timeArray[1]))
            @php($timeRange = floatval($endTime[0]) - floatval($startTime[0]))
            @php($minute = floatval($endTime[1]) - floatval($startTime[1]))
            @if($minute < 0)
                @php($timeRange = ($timeRange -1) + ($minute / 60))
            @elseif($minute > 0)
                @php($timeRange = $timeRange + ($minute / 60))
            @endif
        <p class="rate">📊 Rate: {{ number_format($class[0]['tuitionfee'] / (  $timeRange * intval($class[0]['dayInAWeek']) * 4 ))  }}k/giờ</p>
        <p class="review">👍👎 Đánh giá của các gia sư trước về phụ huynh và học sinh: </p>
    </div>
</div>
{{--FORM--}}
<h3>Danh sách các gia sư đã nộp hồ sơ</h3>
<br>
<div id="colorInfo">
    <div class="singleColor">
        <div class="color" id="orange"></div>
        <p>Đang chờ duyệt</p>
    </div>
    <div class="singleColor">
        <div class="color" id="blue"></div>
        <p>Đã được duyệt, còn chờ thanh toán phí</p>
    </div>
    <div class="singleColor">
        <div class="color" id="green"></div>
        <p>Đã nhận lớp</p>
    </div>
    <div class="singleColor">
        <div class="color" id="red"></div>
        <p>Hồ sơ không phù hợp</p>
    </div>
</div>
<div id="competitors">
    @for($i = 0; $i < count($competitors); $i++)
        @php($status = $competitors[$i][0]['status'])
        <div class="singleCompetitor" style="background-color: @if($status == "approval") #25D366 @elseif($status == "evaluating") #FF9900 @elseif($status == "waiting") #0085C @elseif($status == "failed") #ED1C16 @endif">
            <img class="avatar" src="{{ asset('../resources/images/avatar/'. $competitors[$i][0]['id'] .'.jpg')}}">
            <p class="tutorName">{{ $competitors[$i][0]['name'] }}</p>
        </div>
    @endfor
</div>
<div id="footer">

</div>
</body>
</html>

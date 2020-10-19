<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/upperCSS.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/homepageCSS.css')}}">
        <script src="{{ asset('../resources/js/upperJS.js') }}"></script>
        <script src="{{ asset('../resources/js/homepageJS.js') }}"></script>
        <title>Tutor Center</title>
    </head>
    <body>
        @include('upper')
        <p id="title">Lớp mới nổi bật</p>
        <div id="strikingClasses">
            <form id="classForm" action="/Code/tutorcenter/public/classdetail" method="POST">
                @csrf
                <input name="classID" id="classID" value="">
            </form>
            @for($i = 0; $i < count($stack); $i++)
                @php($index = $stack[$i])
                <div class="classes" id="class{{ $i }}">
                    <p class="classID" id="{{ $strikingClass[$index]['id'] }}">Mã lớp đây: {{ $strikingClass[$index]['id'] }}</p>
                    <hr>
                    @foreach($subject as $singleSubject)
                        @if($strikingClass[$index]['subject'] == $singleSubject['code'])
                            <p class="subject"> &#x1F4D6; Môn: {{ $singleSubject['name'] }}</p>
                        @endif
                    @endforeach
                    <p class="grade">Lớp: {{ $strikingClass[$index]['grade'] }}</p>
                    <p class="studentGender">Dạy học sinh {{ strtolower($strikingClass[$index]['studentgender']) }} @if(strtolower($strikingClass[$index]['studentgender']) == "nam") 👦 @else 👧 @endif</p>
                    <p class="level">Học lực: {{ $strikingClass[$index]['studentlevel'] }}</p>
                    <p class="tuitionFee">💵 Học phí: {{ number_format($strikingClass[$index]['tuitionfee']) }} VND</p>
                    @php($timeArray = explode("to", $strikingClass[$index]['time']))
                    <p class="time"> &#x1F555; Thời gian dạy: Từ {{ $timeArray[0] }} đến {{ $timeArray[1] }}</p>
                    <p class="numOfDay">🚲 Dạy {{ $strikingClass[$index]['dayInAWeek'] }} buổi một tuần</p>
                    <p class="reqirement"> ⚠ Yêu cầu gia sư:
                        @php($requirementArray = explode(". ", $strikingClass[$index]['requirements']))
                        @foreach($requirementArray as $singleRequirement)
                            @if($singleRequirement == null)
                                <br> Không có
                                @break
                            @endif
                            <br> • {{ $singleRequirement }}
                        @endforeach
                    </p>
                </div>
            @endfor
        </div>
        <button id="accessAllClasses" type="button">Xem tất cả các lớp >></button>
        <div id="controlButton">
            <button id="previous" type="button"> < </button>
            <button id="next" type="button"> > </button>
        </div>
        <div id="aboutUs">

        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=David+Libre&family=Miriam+Libre&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/upperCSS.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/css/allclassesCSS.css')}}">
    <script src="{{ asset('../resources/js/upperJS.js') }}"></script>
    <script src="{{ asset('../resources/js/allClassesJS.js') }}"></script>
    <title>Tutor Center</title>
</head>
<body>
{{--    LOADING ANIMATION--}}
    <div class ="wrapper">
        <div id="loading" class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>
    @include('upper')
    <div id="panel">
        <h3>This is the panel</h3>
    </div>
    <div id="container">
        <form id="classForm" action="/Code/tutorcenter/public/classdetail" method="POST">
            @csrf
            <input name="classID" id="classID" value="">
        </form>
        <h3>Sắp xếp các lớp theo:</h3>
{{--        SORT BY SUBJECT--}}
        <div id="classFilter">
            <div class="filterWrapper">
                <pre>Môn học: </pre>
                <select id="subjectFilter">
                    <option value="none" selected>Chọn môn</option>
    {{--                SUBJECT IN SCHOOL--}}
                    <optgroup label="Các môn ở trường">
                        @foreach($subject as $singleSubject)
                            <option value="{{ $singleSubject['code'] }}">{{ $singleSubject['name'] }}</option>
                        @endforeach
                    </optgroup>
    {{--                SUBJECT NOT IN SCHOOL--}}
                    <optgroup label="Các môn tự chọn">

                    </optgroup>
                </select>
            </div>
{{--            SORT BY GRADE--}}
            <div class="filterWrapper">
                <pre>Lớp: </pre>
                <select id="gradeFilter">
                    <option value="none" selected>Chọn lớp</option>
                    <optgroup label="Các lớp theo hệ giáo dục ở trường">
                        @for($i = 1; $i < 13; $i++)
                            <option value="{{ $i }}">Lớp {{ $i }}</option>
                        @endfor
                    </optgroup>
                    {{--                CLASS NOT IN SCHOOL--}}
                    <optgroup label="Các lớp tự chọn">
                        <option value="basicCommunicate">Giao tiếp cơ bản</option>
                    </optgroup>
                </select>
            </div>

{{--            SORT BY TIME--}}
            <div class="filterWrapper">
                <pre>Thời gian dạy:  </pre>
                <select id="timePicker">
                    <option value="none">Chon thời gian</option>
                    <option value="morning">Sáng (Từ 7:00 đến 12:00)</option>
                    <option value="afternoon">Chiều (Từ 12:00 đến 17:00)</option>
                    <option value="evening">Tối (Từ 17:00 đến 22:00)</option>
                </select>
            </div>
{{--            SORT BY NUMBER OF DAYS IN A WEEK--}}
            <div class="filterWrapper">
                <pre>Số buổi: </pre>
                <select id="numOfDayFilter">
                    <option value="none" selected>Chọn số buổi dạy</option>
                        @for($i = 1; $i < 8; $i++)
                            <option value="{{ $i }}">{{ $i }} buổi</option>
                        @endfor
                </select>
            </div>
        </div>
        <br>

{{--        CLASSES HERE--}}
        <div id="classWrapper">
            @for($i = 0; $i < count($class); $i++)
                <div class="classes" id="class{{ $class[$i]['id'] }}">
                    <p class="classID">Mã lớp: {{ $class[$i]['id'] }}</p>
                    <hr>
                    @foreach($subject as $singleSubject)
                        @if($class[$i]['subject'] == $singleSubject['code'])
                            <p class="subject"> &#x1F4D6; Môn: {{ $singleSubject['name'] }}</p>
                        @endif
                    @endforeach
                    <p class="grade">Lớp: {{ $class[$i]['grade'] }}</p>
                    <p class="studentGender">Dạy học sinh {{ strtolower($class[$i]['studentgender']) }} @if(strtolower($class[$i]['studentgender']) == "nam") 👦 @else 👧 @endif</p>
                    <p class="level">Học lực: {{ $class[$i]['studentlevel'] }}</p>
                    <p class="tuitionFee">💵 Học phí: {{ number_format($class[$i]['tuitionfee']) }} VND</p>
                    @php($timeArray = explode("to", $class[$i]['time']))
                    <p class="time"> &#x1F555; Thời gian dạy: Từ {{ $timeArray[0] }} đến {{ $timeArray[1] }}</p>
                    <p class="numOfDay">🚲 Dạy {{ $class[$i]['dayInAWeek'] }} buổi một tuần</p>
                    <p class="reqirement"> ⚠ Yêu cầu gia sư:
                        @php($requirementArray = explode(". ", $class[$i]['requirements']))
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
    </div>
    <div id="footer">

    </div>
</body>
</html>

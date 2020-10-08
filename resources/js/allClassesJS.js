$(document).ready(function() {
    $("body").fadeIn(1000);
    window.subjectCondition = "";
    window.gradeCondition = "";
    window.numOfDayCondition = "";
    $("#subjectFilter, #gradeFilter, #numOfDayFilter").change(function () {
        $(".wrapper").fadeIn(500);
        var searchKey = $(this.options[this.selectedIndex]).val();
        $("#classWrapper").css("display", "none");
        if(($(this).attr("id")) == ("subjectFilter")) {
            if (searchKey != "none") {
                subjectCondition = searchKey;
            }
            else {
                subjectCondition = "";
            }
        }
        if(($(this).attr("id")) == ("gradeFilter")) {
            if (searchKey != "none") {
                gradeCondition = searchKey;
            }
            else {
                gradeCondition = "";
            }
        }
        if(($(this).attr("id")) == ("numOfDayFilter")) {
            if (searchKey != "none") {
                numOfDayCondition = searchKey;
            }
            else {
                numOfDayCondition = "";
            }
        }
        // SEND QUERY TO SERVER
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "content-type" : "application/json"
            },
            url: '/Code/tutorcenter/public/sortClass',
            type: 'POST',
            data: JSON.stringify({subject:subjectCondition, grade:gradeCondition, numOfDay:numOfDayCondition}),
            success: function(data) {
                $(".wrapper").fadeOut(1000);
                displaySortedClass(data["class"][0], data["subject"]);
            },
            error: function(data) {
                console.log("Error getting JSON file from SERVER!");
            }
        });
    });

    $(".classes").mouseover(function () {
        onMouseOver(this);
    });
    $(".classes").mouseleave(function () {
        onMouseLeave(this);
    });
    $(".classes").click(function () {
        var id = ($(this).attr("id")).split("ss")[1];
        $("#classID").attr("value", id);
        $("#classForm").submit();
    });
    // ALL FUCNTIONS HERE
    function displaySortedClass(data, subject) {
        var classWrapper = document.getElementById("classWrapper");
        $(".classes").remove();
        for (var i = 0; i < data.length; i++) {
            // CLASS
            var classes = document.createElement("div");
            classes.className = "classes";
            classes.id = "class" + data[i]['id'];
            // CLASSID
            var classID = document.createElement("p");
            classID.className = "classID";
            var classValue = document.createTextNode("Mã lớp: ".concat(data[i]['id']));
            classID.appendChild(classValue);

            // SUBJECT
            var classSubject = document.createElement("p");
            classSubject.className = "subject";
            for (var k = 0; k < subject.length; k++) {
                if(data[i]['subject'] == subject[k]['code']) {
                    var classValue = document.createTextNode("📖 Môn: ".concat(subject[k]['name']));
                    classSubject.appendChild(classValue);
                    break;
                }
            }

            // GRADE
            var classGrade = document.createElement("p");
            classGrade.className = "grade";
            classValue = document.createTextNode("Lớp: ".concat(data[i]['grade']));
            classGrade.appendChild(classValue);
            // GENDER
            var studentGender = document.createElement("p");
            studentGender.className = "studentGender";
            if(data[i]['studentgender'].toLowerCase() === ("nữ")) {
                var tempString = "Dạy học sinh ".concat(data[i]['studentgender'].toLowerCase() + " 👧");
            }
            else {
                var tempString = "Dạy học sinh ".concat(data[i]['studentgender'].toLowerCase() + "  👦");
            }
            classValue = document.createTextNode(tempString);
            studentGender.appendChild(classValue);

            // LEVEL
            var studentLevel = document.createElement("p");
            studentLevel.className = "level";
            classValue = document.createTextNode("Học lực: ".concat(data[i]['studentlevel']));
            studentLevel.appendChild(classValue);

            // TUITION FEE
            var tuitionFee = document.createElement("p");
            tuitionFee.className = "tuitionFee";
            classValue = document.createTextNode("💵 Học phí: ".concat(number_Format(data[i]['tuitionfee'])));
            tuitionFee.appendChild(classValue);

            // TIME
            var time = document.createElement("p");
            time.className = "time";
            var timeArray = data[i]['time'].split("to");
            classValue = document.createTextNode("🕕 Thời gian dạy: Từ ".concat(timeArray[0]) + " đến ".concat(timeArray[1]));
            time.appendChild(classValue);

            // NUMBER OF DAY
            var numOfDay = document.createElement("p");
            numOfDay.className = "numOfDay";
            classValue = document.createTextNode("🚲 Dạy ".concat(data[i]['dayInAWeek']).concat(" buổi một tuần"));
            numOfDay.appendChild(classValue);

            // REQUIREMENTS
            var requirement = document.createElement("div");
            requirement.className = "requirement";
            var requirementArray = data[i]['requirements'].split(". ");
            tempString = "⚠ Yêu cầu gia sư:";
            classValue = document.createTextNode(tempString);
            requirement.appendChild(classValue);
            requirement.append(document.createElement("br"));
            for (var l = 0; l < requirementArray.length; l++) {
                if (requirementArray[0] === "") {
                    tempString = " Không có";
                    classValue = document.createTextNode(tempString);
                    requirement.appendChild(classValue);
                    break;
                }
                tempString = "• " + requirementArray[l];
                classValue = document.createTextNode(tempString);
                requirement.appendChild(classValue);
                requirement.appendChild(document.createElement("br"));
            }

            // APPEND ALL ABOVE ELEMENT TO CLASS
            classes.appendChild(classID);
            classes.appendChild(document.createElement("hr"));
            classes.appendChild(classSubject);
            classes.appendChild(classGrade);
            classes.appendChild(studentGender);
            classes.appendChild(studentLevel);
            classes.appendChild(tuitionFee);
            classes.appendChild(time);
            classes.appendChild(numOfDay);
            classes.appendChild(requirement);
            classWrapper.appendChild(classes)
        }
        $(".classes").mouseover(function () {
            onMouseOver(this);
        });
        $(".classes").mouseleave(function () {
            onMouseLeave(this);
        });
        $(".classes").click(function () {
            var id = ($(this).attr("id")).split("ss")[1];
            $("#classID").attr("value", id);
            $("#classForm").submit();
        });
        $("#classWrapper").fadeIn(1000);
    }
    function number_Format(num)
    {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }
    function onMouseOver(target) {
        $(target).css("-webkit-transform", "scale(1.1)");
        $(target).css("-webkit-transition", "-webkit-transform 0.35s");
        $(target).css("transform", "scale(1.1)");
        $(target).css("z-index", "1");
    }
    function onMouseLeave(target) {
        $(target).css("-webkit-transform", "scale(1.0)");
        $(target).css("-webkit-transition", "-webkit-transform 0.35s");
        $(target).css("transform", "scale(1.0)");
        $(target).css("z-index", "0");
    }
});

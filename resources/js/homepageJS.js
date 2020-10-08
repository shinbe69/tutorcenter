$(document).ready(function() {
        $("body").fadeIn(1000);
        $("#searchDiv").fadeIn(3000);
        document.getElementById("searchButton").disabled = true;
        window.i = window.preIndex = 0;
        // CHANGE CONTROL BUTTON EFFECT
        $("#previous, #next").mouseover(function() {
            $(this).css("-webkit-transform", "scale(1.2)");
            $(this).css("-webkit-transition", "-webkit-transform 0.35s");
            $(this).css("transform", "scale(1.2)");
        });
        $("#previous, #next").mouseleave(function() {
            $(this).css("-webkit-transform", "scale(1.0)");
            $(this).css("-webkit-transition", "-webkit-transform 0.35s");
            $(this).css("transform", "scale(1.0)");
        });

        // SET EFFECT FOR EVERY STRIKING CLASSES
        changeStriking();
        setInterval(function(){
            i++
            if(i == 8) {
                i = 0;
            }
            changeStriking();
            preIndex = i;
        }, 5000);

        // CHANGE INDEX OF STRIKING CLASS WHEN CLICK PREVIOUS OR NEXT BUTTON
        $("#previous").click(function () {
            i = i--;
            changeStriking();
        });

        $("#next").click(function () {
            i = i++;
            if(i == 8) {
                i = 0;
            }
            changeStriking();
        });

        // SET POSITION OF ACCESSALLCLASSES BUTTON IN THE BOTTOM RIGHT OF STRIKING CLASS
        $("#strikingClasses").ready(function () {
            var distance = $(window).width() - $("#strikingClasses").width();
            $("#accessAllClasses").css("right", distance/2 - 10);
        });

        // SEE DETAIL CLASS WHEN CLICK ON
    $(".classes").click(function () {
        var id = ($(this).find(".classID")).attr("id");
        $("#classID").attr("value", id);
        $("#classForm").submit();
    });


        // GO TO ALL CLASSES PAGE
        $("#accessAllClasses").click(function () {
            window.location.assign("/Code/tutorcenter/public/allclasses");
        });

        // CHANGE STRIKING CLASS FUNCTION
        function changeStriking() {
            var stringkingClass = $("#class".concat(i));
            var prestringkingClass = $("#class".concat(preIndex));
            prestringkingClass.css("-webkit-transform", "scale(1.0)");
            prestringkingClass.css("-webkit-transition", "-webkit-transform 0.35s");
            prestringkingClass.css("transform", "scale(1.0)");
            prestringkingClass.css("background-color", "aliceblue");

            stringkingClass.css("-webkit-transform", "scale(1.2)");
            stringkingClass.css("-webkit-transition", "-webkit-transform 0.35s");
            stringkingClass.css("transform", "scale(1.2)");
            stringkingClass.css("background-color", "lightblue");
        }
        // $(window).resize(function () {
        //     $("#strikingClasses").ready(function () {
        //         var distance = $(window).width() - $("#strikingClasses").width();
        //         $("#accessAllClasses").css("right", distance/2 - 10);
        //     });
        // });
});

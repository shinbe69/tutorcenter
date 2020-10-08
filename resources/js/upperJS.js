$(document).ready(function() {

    $("#logo p").click(function() {
        window.location.assign('/Code/tutorcenter/public/');
    });
    $("#login, #loginImg").click(function() {
        window.location.assign('/Code/project3/public/login');
    });
    $("#logout, #logoutImg").click(function() {
        $('body').fadeOut(1000);
        window.location.assign("/Code/project3/public/logout");
    });
    $("#search").click(function() {
        // blur();
    });
    var searchBox = document.getElementById('searchbox');
    window.onclick = function(event) {
        if (event.target != searchBox) {
            $("#dropDownResult").css("display", "none");
            // unblur();
        }
    }

    $('#searchbox').on('input',function(){
        // SET WIDTH FOR DROPDOWN SEARCH LIST
        var searchBoxWidth = $("#searchbox").width();
        $("#dropDownResult").width(searchBoxWidth);
        let content = document.getElementById("searchbox").value.toLowerCase();
        content = content.trim();
        if(content == "") {
            $("#dropDownResult").css("display", "none");
            $(".resultRow").remove();
            $(".hrSeparate").remove();
        }
        else {
            // SEND SERACH KEY TO SERVER TO GET SUITABLE DATA
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "content-type" : "application/json"
                },
                url: '/Code/tutorcenter/public/getSearchKey',
                type: 'POST',
                data: JSON.stringify({searchKey:content}),
                success: function(data) {
                    window.searchData = data;
                    // DISPLAY RESULT ROW
                    $(".resultRow").remove();
                    $(".hrSeparate").remove();
                    var i;
                    var dropdownResult = document.getElementById("dropDownResult");
                    for (i = 0; i < searchData.length; i++) {
                        if(i == 10) {
                            break;
                        }
                            var resultRow = document.createElement("div");
                            var hrSeparate = document.createElement("hr");
                            var value = document.createTextNode(searchData[i]);
                            hrSeparate.className = "hrSeparate";
                            resultRow.appendChild(value);
                            resultRow.className = "resultRow";
                            dropdownResult.appendChild(resultRow);
                            dropdownResult.appendChild(hrSeparate);
                    }
                    $("#dropDownResult").css("display", "block");

                },
                error: function(data) {
                    console.log("Error getting JSON file from SERVER!");
                }
            });
        }
    });

    function blur() {
        $("#wrapper, #logo, #account").animate({ opacity: '0.3' }, 'fast');
    }

    function unblur() {
        $("#wrapper, #logo, #account").animate({ opacity: '1.0' });
    }
});

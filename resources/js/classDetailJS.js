$(document).ready(function () {
   $("body").fadeIn(1000);
   $("#classWrapper ").ready(function () {
       $("#classDetail").css("max-height", $("#classWrapper").height());
   });
   $("#takeClass").click(function () {
      $("#formArea").fadeIn(1000);
   });
});

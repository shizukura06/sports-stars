$(document).ready(function (){

});
function switch_player(e){
    if($(e).data("player") != 0) {
        var dataString = "ajax=1&id=" + $(e).data("player");
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: dataString,
            cache: false,
            beforeSend: function (html3) {
                // maybe loading animation??
                //console.log(dataString);
                $("#global_loading").show();
            },
            success: function (html) {
                $("body").empty().append(html);
                $("#global_loading").hide();

            },
            error: function (html2) {
                alert(html2.errorCode);
                $("#global_loading").hide()
            }
        });
    }
}

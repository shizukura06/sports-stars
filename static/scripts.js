$(document).ready(function (){

});
function switch_player(e,a = 0){
    if ((a == 0) && (e == 0)){
        var dataString2 = "ajax=" + (is_allblacks ? "1":"2") +"&id=1";
        console.log(dataString2);
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: dataString2,
            cache: false,
            beforeSend: function (html3) {
                $("#global_loading").show();
            },
            success: function (html) {
                $("body").empty().append(html);
                player_type_checker();
                $("#global_loading").hide();

            },
            error: function (html2) {
                alert(html2.errorCode);
                $("#global_loading").hide()
            }
        });
    }
    else if($(e).data("player") != 0) {
        var dataString = "ajax="+(a ? "1":"2")+"&id=" + $(e).data("player");
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
                player_type_checker();
                $("#global_loading").hide();

            },
            error: function (html2) {
                alert(html2.errorCode);
                $("#global_loading").hide()
            }
        });
    }
}

function player_type_checker(){
    if(is_allblacks){
        $("h1").removeClass("gsw_h1");
        $(".card").removeClass("gsw_card");
        $(".card_previous,.card_next").removeClass("gsw_ui");
        $(".switch_game").removeClass("switch_game_nba");
    } else{
        $("h1").addClass("gsw_h1");
        $(".card").addClass("gsw_card");
        $(".card_previous,.card_next").addClass("gsw_ui");
        $(".switch_game").addClass("switch_game_nba");

    }
}

function switch_game(){
    if(is_allblacks){
        is_allblacks = false;
        switch_player(0);
    } else{
        is_allblacks = true;
        switch_player(0);
    }
}

$(document).ready(function () {
    $(window).load(function () {
        $('.loading').fadeOut("slow");
        var bookid = $('.bookid').val();
        $.ajax({
            url: 'getBookInfo.php',
            type: 'POST',
            data: {
                bookid: bookid
            },
            success: function (msg) {
                var data = JSON.parse(msg);
                $('.data-name').html(shorten(data.name));
                $('.data-img').attr('src', "../../"+data.path);
                $('.data-title').html(data.name);
                $('.data-publisher').html(data.publisher);
                $('.data-description').html(data.description);
                for(var prop in data){
                    if(!(data[prop].number === undefined)){
                        var $html = "<tr><td class='fit'>"+data[prop].number+"</td><td class='fit'>"+data[prop].name+"</td>";
                        $('.table-responsive .table tbody').html($('.table-responsive .table tbody').html()+$html);
                    }
                }
            }
        });
    });
});

var shorten = function (title) {
    var spaceCount = 0;
    var secondSpacePos = 0;
    for(var i = 0; i < title.length; i++){
        if(title[i] == ' '){
            spaceCount++;
        }
        if(spaceCount == 2){
            secondSpacePos = i;
            break;
        }
    }
    return title.substring(0, secondSpacePos)+" ...";
};
  /*http://api.jqueryui.com/sortable/*/
  
function sliderSort(element, url) {
    var id, pos, num, data_id = 0;
    
    
    $(element).sortable({
        placeholder: "ui-state-highlight",
        stop: function (event, ui) {
            num = $(ui.item).attr('data-slide-to');
            pos = $(ui.item).index();
            id = $(ui.item).attr('data-id');
            
            $.get(url + id + "?js=1&from=" + num + "&pos=" + pos, function( data ) {
                if(null !== data){
                    var indicators = $(".carousel-indicators li").get();
                    var itens = $(".carousel-inner div.item").get();
                    for ( var i = 0; i < indicators.length; i++ ) {
                        data_id = $(indicators[i]).attr('data-id');
                        itens[i] = $(".carousel-inner div.item[data-id='" + data_id + "']").clone();
                        $(".carousel-inner div.item[data-id='" + data_id + "']").remove();
                        $(indicators[i]).attr('data-slide-to', i);
                    }
                    for ( var i = 0; i < itens.length; i++ ) {
                        $("#myCarousel div.carousel-inner").append(itens[i]);
                    }
                    
                }
            });
        }
    });
    $(element).disableSelection();
}


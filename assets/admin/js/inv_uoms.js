$(document).ready(function(){

    $(document).on('input','#search_by_text',function(e){
        make_search();
    });
    $(document).on('change','#is_master_search',function(e){
        make_search();
    });

    function make_search(){
        var searchByText = $('#search_by_text').val();
        var is_master_search = $("#is_master_search").val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();
        jQuery.ajax({
            url: ajax_search_url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {searchByText:searchByText,"_token":token_search, is_master_search:is_master_search},
            success: function(data){
                $("#ajax_response_searchDiv").html(data);
            },
            error: function(){
            }
        });
    }


    $(document).on('click','#ajax_pagination_in_search a ',function(e){

        e.preventDefault();
        var searchByText = $('#search_by_text').val();
        var Url = $(this).attr("href");
        var token_search = $("#token_search").val();
        jQuery.ajax({
            url: Url,
            type: 'post',
            dataType: 'html',
            cache: false,
            data: {searchByText:searchByText,"_token":token_search},
            success: function(data){
                $("#ajax_response_searchDiv").html(data);
            },
            error: function(){

            }
        });
    })

});

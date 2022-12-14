$('.btnselect').click(function(){
        id = $(this).attr('data_id');
     mois = $(this).attr('data_mois');
     detail = $('#details');

        if ($(this).is(':checked')){
            $.ajax({
                url: "/ajax",
                type: 'POST', 
                data:{'id':id, 'mois':mois
                },
                success:function(result){
                    detail.append(result);
                }
            });
        }
            else{
                   document.getElementById(id).remove();
                }
});

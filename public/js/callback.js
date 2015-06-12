;(function(){
    $('form[method="POST"]').submit(function(e){
        console.log($(this).find('input[name="_method"][value="DELETE"]'));
        if($(this).find('input[name="_method"][value="DELETE"]').length>0 && !confirm('Вы действительно хотите удалить этот элемент?')){
            return false;
        };
    });

    $('p.color').click(function(e){
        $('p.color').removeClass('active');
        $(this).addClass('active');
        $("input#colors").val($(this).data('color'));
    })

}())
 $(window).load(function(){
            
            $("a[rel='load-content']").click(function(e){
                e.preventDefault();
                var url=$(this).attr("href");
                $.get(url,function(data){
                    $(".content .mCSB_container").append(data); //load new content inside .mCSB_container
                    //scroll-to appended content 
                    $(".content").mCustomScrollbar("scrollTo","h2:last");
                });
            });

            $(".content").delegate("a[href='top']","click",function(e){
                e.preventDefault();
                $(".content").mCustomScrollbar("scrollTo",$(this).attr("href"));
            });
        
//左侧菜单收缩
        $("#left_nav > li > dl ").each(function(){
            $(this).find('dd').each(function(){
                if($(this).find('a').hasClass('active')){
                    $(this).parent().parent().find('dd').animate({height:"40px"}).show();
                    return false;
                }
            })
        })

        $("#left_nav > li > dl > dt ").click(function(){

            $("#left_nav > li > dl > dt ").each(function(){
                if($(this).parent().find('dd').is(":visible")){
                    $(this).parent().find('dd').stop().animate({height:"0px"},300,function(){
                        $(this).hide();
                    })
                }
            })

            if($(this).parent().find('dd').is(":hidden")){
                $(this).parent().find('dd').show();
                $(this).parent().find('dd').stop().animate({height:"40px"},300)
            }
            else{
                $(this).parent().find('dd').stop().animate({height:"0px"},300,function(){
                    $(this).hide();
                })
            }

        })
//左侧菜单收缩


});

//全屏遮罩
$("#loading").click(function(){
    $(".loading_area").fadeIn();
        $(".loading_area").fadeOut(1500);
    });


//弹出文本性提示框
function showAlert(info,url1,url2){
    $(".pop_bg").fadeIn();
    $("#pop_cont_text").html(info);
    $(".trueBtn").attr('urls',url1);
    $(".falseBtn").attr('urls',url2);
}

 //弹出：确认按钮
 $(".trueBtn").click(function(){
     if($(this).attr('urls')!='') window.location.href=$(this).attr('urls');
     else $(".pop_bg").fadeOut();
     });
 //弹出：取消或关闭按钮
 $(".falseBtn").click(function(){
     if($(this).attr('urls')!='') window.location.href=$(this).attr('urls');
     else $(".pop_bg").fadeOut();
     });
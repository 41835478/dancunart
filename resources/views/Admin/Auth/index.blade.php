@extends('Admin.app')
@section('content')
<section class="rt_wrap content mCustomScrollbar">
 <div class="rt_content">
     <h1>{{$title}}</h1>

     <section>
      <ul class="ulColumn2">
       <li>
        <span class="item_name" style="width:120px;">管理员账号：</span>
        <input type="text" readonly class="textbox textbox_295" value="{{$data->name}}"/>
       </li>

      <li>
          <span class="item_name" style="width:120px;">管理员名称：</span>
          <input type="text" readonly class="textbox textbox_295" value="{{$data->nick}}"/>
      </li>

       <li>
        <span class="item_name" style="width:120px;">新密码：</span>
        <input type="password" class="textbox textbox_295" placeholder="请输入新密码..." name="pwd1"/>
       </li>

       <li>
        <span class="item_name" style="width:120px;">确认密码：</span>
        <input type="password" class="textbox textbox_295" placeholder="请再次输入..." name="pwd2"/>
       </li>

       <li>
        <span class="item_name" style="width:120px;"></span>
        <input type="submit" class="link_btn"/>
       </li>
      </ul>
     </section>

 </div>
</section>

@endsection
@section('footer')
<script>
  //登录view验证
  $(".link_btn").click(function(){
      var pwd1 = $("input[name = 'pwd1']").val().length;
      var pwd2 = $("input[name = 'pwd2']").val().length;

      if(pwd1<6)  showAlert('密码不得低于6位','','');

      else if(pwd1!=pwd2)  showAlert('两次密码不一致','','');

      else{
          $.ajax({
              url  : "{{URL::to('admin/auth')}}",
              type : "post",
              data : "pwd="+$("input[name = 'pwd1']").val()+"&_token={{csrf_token()}}",
              dataType: "json",
              beforeSend:function(){
              $(".loading_area").fadeIn();
                },
              success:function(result){
              if(result.errorno==30000){
                  showAlert(result.msg,'{{URL::to('admin/login')}}','{{URL::to('admin/login')}}');
              }
              else {
                  $(".loading_area").fadeOut(1500);
                  showAlert(result.msg,'','');
              }
          }
          })
      }
  })
  </script>
</body>
</html>
@endsection
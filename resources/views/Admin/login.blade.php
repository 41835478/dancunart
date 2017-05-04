<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>后台登录</title>
<meta name="author" content="Charis" />
<link rel="stylesheet" type="text/css" href="{{asset('static/css/style.css')}}" />
<style>
body{height:100%;background:#16a085;overflow:hidden;}
canvas{z-index:-1;position:absolute;}
</style>
<script src="{{asset('static/js/jquery.js')}}"></script>
<script src="{{asset('static/js/verificationNumbers.js')}}"></script>
<script src="{{asset('static/js/Particleground.js')}}"></script>
<script>
$(document).ready(function() {
  //粒子背景特效
   $('body').particleground({
     dotColor: '#5cbdaa',
     lineColor: '#5cbdaa'
   });
  //验证码
  createCode();
  //登录view验证
  $("#login_btn").click(function(){
    var user_name = $("input[name = 'user_name']").val();
    var user_psw = $("input[name = 'user_password']").val();
      if(user_name=='')  alert('请填写账号')
      else if(user_psw=='') alert('请填写密码')
      else if(validate()==false)  alert('验证码有误')
      else{
        $.post("login",{user_name:user_name,user_password:user_psw,_token:'{{csrf_token()}}'},function(result){
          result=jQuery.parseJSON(result);
          if(result.errorno==0) window.location.href="/admin";
          else {alert('账号或密码错误');createCode();}
        });
      }
  })
  
  //回车登录事件
  $(document).keyup(function(event){
    if(event.keyCode ==13){
      $("#login_btn").trigger("click");
    }
  });

});

</script>
</head>
<body>
<dl class="admin_login">
 <dt>
  <strong>{{config('app.title')}}</strong>
  <em>{{config('app.title_en')}}</em>
 </dt>
 <dd class="user_icon">
  <input type="text" placeholder="账号" class="login_txtbx" name="user_name"/>
 </dd>
 <dd class="pwd_icon">
  <input type="password" placeholder="密码" class="login_txtbx" name="user_password"/>
 </dd>
 <dd class="val_icon">
  <div class="checkcode">
    <input type="text" id="J_codetext" placeholder="验证码" maxlength="4" class="login_txtbx">
    <canvas class="J_codeimg" id="myCanvas" onclick="createCode()">对不起，您的浏览器不支持canvas，请下载最新版浏览器!</canvas>
  </div>
  <input type="button" value="更换验证码" class="ver_btn" onClick="validate();">
 </dd>
 <dd>
  <input type="button" value="立即登陆" class="submit_btn" id="login_btn"/>
 </dd>
 </form>
 <dd>
  <p>{{config('app.title')}}</p>
  <p>{{config('app.copyright')}}</p>
 </dd>
</dl>
</body>
</html>

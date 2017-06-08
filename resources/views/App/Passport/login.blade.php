@extends('App.common_SPA')
@section('content')
    <template class="">
        <el-carousel :interval="5000" arrow="always">

                <el-carousel-item>
                    <img src="http://192.168.1.26:82/uploads/2017/06_02/banner1.jpg">
                </el-carousel-item>

        </el-carousel>
        <div class="lc_passport padding5">


                    <el-tabs v-model="activeName">
                    <el-tab-pane class="lc_passport_login" label="会员账号登录" name="first">
                        <el-form :model="login_account" ref="login_account" :rules="rules">

                            <el-form-item label="" prop="account">
                                <el-input size="large" v-model="login_account.account" placeholder="用户名/邮箱"></el-input>
                            </el-form-item>

                            <el-form-item label="" prop="password">
                                <el-input size="large" v-model="login_account.password" type="password" placeholder="请输入密码"></el-input>
                            </el-form-item>

                            <el-button type="info" @click="login('account')">登 录</el-button>
                        </el-form>

                    </el-tab-pane>

                    <el-tab-pane class="lc_passport_mob" label="手机快速登录" name="second">
                        <el-form :model="login_mob" ref="login_mob" :rules="rules">
                            <el-form-item label="" prop="mob">
                                <el-input size="large" v-model="login_mob.mob" placeholder="手机号"></el-input>
                            </el-form-item>

                            <el-form-item label="" prop="captcha">
                                <el-input size="large" v-model="login_mob.captcha" placeholder="图形验证码">
                                    <template slot="append"><img id="Captcha" @click="changeCaptcha" src="{{url('/Passport/captcha')}}" /></template>
                                </el-input>
                            </el-form-item>

                            <el-form-item label="" prop="vercode">
                                <el-input size="large" placeholder="短信验证码" v-model="login_mob.vercode">
                                    <template slot="append" >
                                        <div @click="sendSms" v-if="time==60">发送验证码</div>
                                        <div v-else>@{{time}}秒后可重发</div>
                                    </template>
                                </el-input>
                            </el-form-item>

                        <el-button type="info" @click="login('mob')" :disabled="reg_status">登 录</el-button>
                        </el-form>
                    </el-tab-pane>
                    </el-tabs>

    <div class="lc_passport_tip">
        <a href="{{url('/Passport/zhmm')}}">找回密码?</a><a href="{{url('/Passport/register')}}?redirect={{$redirect}}">注册账号</a>
    </div>
        </div>
    </template>

    <el-dialog
            title="提示"
            :visible.sync="dialogVisible"
            size="tiny">
        <span v-html="dialogInfo"></span>
        <span slot="footer" class="dialog-footer">
            <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
        </span>
    </el-dialog>

@endsection
@section('footer')

    <script>

        var app = new Vue({
            el: '#app_SPA',
            data: function() {
                return {
                    activeName: 'first',
                    dialogVisible: false,
                    dialogInfo:'',
                    time:60,
                    checked:false,
                    reg_status:false,
                    login_account:{
                        account:'',
                        password:'',
                    },
                    login_mob:{
                        mob:'',
                        captcha:'',
                        vercode:'',
                    },
                    rules:{
                        account: [
                            { required: true, message: '请输入账号', trigger: 'change' },
                            { min: 3,  message: '长度不正确', trigger: 'change' },
                        ],
                        password:[
                            { required: true, message: '请输入密码', trigger: 'change' },
                            { min: 6,  message: '长度不正确', trigger: 'change' },
                        ],
                        mob: [
                            { required: true, message: '请输入手机号', trigger: 'change' },
                            {pattern:/^1[3,4,5,7,8]\d{9}$/, message: '不是正确的手机号'}
                        ],
                        captcha: [
                            { required: true, message: '请输入图形验证码', trigger: 'change' },
                            { min: 5, max: 5, message: '长度不正确', trigger: 'change' },
                        ],
                        vercode:[
                            { required: true, message: '请输入短信验证码', trigger: 'change' },
                            { min: 6, max: 6, message: '长度不正确', trigger: 'change' }
                        ]
                    }
                }
            },
            methods:{
                changeCaptcha:function(){
                    var src = document.getElementById('Captcha').src;
                    document.getElementById('Captcha').src = '';
                    document.getElementById('Captcha').src = src+'?';
                },
                sendSms:function(){
                    var str = /^1[3,4,5,7,8]\d{9}$/;
                    var account = this.login_mob.account;
                    if(str.test(account)){
                        if(this.login_mob.captcha.length==5)
                            axios.get('{{url('/Passport/checkCaptcha')}}/'+this.login_mob.captcha).then(function(result) {

                                if(result.data==0){
                                    app.dialogVisible=true;
                                    app.dialogInfo='验证码错误'
                                    app.changeCaptcha();
                                    return false;
                                }
                                else{
                                    this.time=59;
                                    var timer = setInterval(function(){
                                        if(app.time<=0){ clearInterval(timer); app.time=60;}
                                        else app.time--;
                                    },1000);
                                }
                            });
                        else {
                            this.dialogVisible=true;
                            this.dialogInfo='请填写验证码'
                            return false;
                        }
                    }
                    else {
                        this.dialogVisible=true;
                        this.dialogInfo='请填写电话'
                    }

                },
                login:function(status){

                    if(status=='mob')
                        this.$refs['login_mob'].validate(function(valid){
                            if (valid) {
                                axios.post('{{url('/Passport/login')}}',{
                                    account: app.login_mob.mob,
                                    vercode: app.login_mob.vercode,
                                    status:status,
                                    _token : '{{csrf_token()}}'
                                }).then(function(result){
                                    if(result.data.errorno == 40000) window.location.href='{{$redirect}}';
                                    else{
                                    app.dialogVisible=true;
                                    app.dialogInfo=result.data.msg;
                                    }
                                }).catch(function (error) {
                                    app.dialogVisible=true;
                                    app.dialogInfo='请求失败，请重试';
                                });
                            }
                        });
                    else
                        this.$refs['login_account'].validate(function(valid){
                            if (valid) {
                                axios.post('{{url('/Passport/login')}}',{
                                    account: app.login_account.account,
                                    password: app.login_account.password,
                                    status:status,
                                    _token : '{{csrf_token()}}'
                                }).then(function(result){
                                    if(result.data.errorno == 40000) window.location.href='{{$redirect}}';
                                    else{
                                        app.dialogVisible=true;
                                        app.dialogInfo=result.data.msg;
                                    }
                                }).catch(function (error) {
                                    app.dialogVisible=true;
                                    app.dialogInfo='请求失败，请重试';
                                });
                            }
                        });
                },
            }
        })

    </script>
@endsection
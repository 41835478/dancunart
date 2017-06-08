@extends('App.common_SPA')
@section('content')
    <template class="">
        <el-carousel :interval="5000" arrow="always">

                <el-carousel-item>
                    <img src="http://192.168.1.26:82/uploads/2017/06_02/banner1.jpg">
                </el-carousel-item>

        </el-carousel>
        <div class="lc_passport lc_passport_register padding5">


                    <el-tabs v-model="activeName">

                    <el-tab-pane label="会员注册" name="first">
                        <el-form :model="ruleForm" ref="ruleForm" :rules="rules" >
                            <el-form-item label="" prop="account">
                                <el-input v-model="ruleForm.account" placeholder="手机号"></el-input>
                            </el-form-item>

                            <el-form-item label="" prop="captcha">
                                <el-input v-model="ruleForm.captcha" placeholder="图形验证码">
                                    <template slot="append"><img id="Captcha" @click="changeCaptcha" src="{{url('/Passport/captcha/100/20')}}" /></template>
                                </el-input>
                            </el-form-item>

                            <el-form-item label="" prop="vercode">
                                <el-input placeholder="短信验证码" v-model="ruleForm.vercode">
                                    <template slot="append" >
                                        <div @click="sendSms" v-if="time==60">发送验证码</div>
                                        <div v-else>@{{time}}秒后可重发</div>
                                    </template>
                                </el-input>
                            </el-form-item>

                            <el-form-item label="" prop="password">
                                <el-input type="password" v-model="ruleForm.password" placeholder="请输入密码"></el-input>
                            </el-form-item>

                            <el-form-item label="" prop="password1">
                                <el-input type="password" v-model="ruleForm.password1" placeholder="请再次输入密码"></el-input>
                            </el-form-item>

                            <el-form-item label="" prop="agreement">
                                <el-checkbox-group v-model="ruleForm.agreement">
                                    <el-checkbox v-model="checked" >我已阅读并同意《<a href="http://www.baidu.com" target="_blank">淡村艺术网用户须知</a>》</el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-button type="info" @click="register" :disabled="reg_status">注 册</el-button>
                        </el-form>
                    </el-tab-pane>
                    </el-tabs>


    <div class="lc_passport_tip"><a href="{{url('/Passport')}}?redirect={{$redirect}}">已有账号？立即登录</a></div>
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
                    ruleForm:{
                        account:'',
                        captcha:'',
                        vercode:'',
                        password:'',
                        password1:'',
                        agreement:[],
                    },
                    rules:{
                        account: [
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
                        ],
                        password: [
                            { required: true, message: '请输入手机号', trigger: 'change' },
                            { min: 6,  message: '至少6位以上', trigger: 'change' }
                        ],
                        password1: [
                            { required: true, message: '请输入手机号', trigger: 'change' },
                            { min: 6,  message: '至少6位以上', trigger: 'change' },
                            {validator:function (rule,value,callback) {
                                if (value !== app.ruleForm.password) {
                                    callback(new Error("两次密码不一致"));
                                } else {
                                    callback();
                                }
                            }}
                        ],
                        agreement:[
                            { type: 'array', required: true, message: '请阅读并同意用户协议', trigger: 'change' }
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
                    var account = this.ruleForm.account;
                    if(str.test(account)){
                        if(this.ruleForm.captcha.length==5)
                            axios.get('{{url('/Passport/checkCaptcha')}}/'+this.ruleForm.captcha).then(function(result) {

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
                register:function(){
                    this.$refs['ruleForm'].validate(function(valid){
                        if (valid) {
                            axios.post('{{url('/Passport/register')}}',{
                                account: app.ruleForm.account,
                                vercode: app.ruleForm.vercode,
                                password: app.ruleForm.password,
                                _token : '{{csrf_token()}}'
                            }).then(function(result){
                                if(result.data.errorno == 70000) window.location.href='{{$redirect}}';
                                else{
                                    app.dialogVisible=true;
                                    app.dialogInfo=result.data.msg;
                                }
                            }).catch(function (error) {
                                console.log(error);
                            });
                        }
                    });
                },
            }
        })

    </script>
@endsection
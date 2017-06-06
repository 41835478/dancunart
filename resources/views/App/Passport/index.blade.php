@extends('App.common_SPA')
@section('content')
    <template class="">
        <el-carousel :interval="5000" arrow="always">

                <el-carousel-item>
                    <img src="http://192.168.1.26:82/uploads/2017/06_02/banner1.jpg">
                </el-carousel-item>

        </el-carousel>
        <div class="lc_passport padding5">

                <el-form :model="ruleForm" ref="ruleForm" :rules="rules" >
                    <el-tabs v-model="activeName">
                    <el-tab-pane class="lc_passport_login" label="会员账号登录" name="first">

                        <el-input size="large" v-model="ruleForm.account" placeholder="用户名/手机号"></el-input>
                        <el-input size="large" v-model="ruleForm.password" type="password" placeholder="请输入密码"></el-input>
                        <el-button type="info" @click="login">登 录</el-button>
                    </el-tab-pane>

                    <el-tab-pane class="lc_passport_register" label="手机快速注册" name="second">

                        <el-form-item label="" prop="account">
                            <el-input size="large" v-model="ruleForm.account" placeholder="手机号"></el-input>
                        </el-form-item>

                        <el-form-item label="" prop="captcha">
                            <el-input size="large" v-model="ruleForm.captcha" placeholder="图形验证码">
                                <template slot="append"><img id="Captcha" @click="changeCaptcha" src="{{url('/Passport/captcha')}}" /></template>
                            </el-input>
                        </el-form-item>

                        <el-form-item label="" prop="vercode">
                            <el-input size="large" placeholder="短信验证码" v-model="ruleForm.vercode">
                                <template slot="append" >
                                    <div @click="sendSms" v-if="time==60">发送验证码</div>
                                    <div v-else>@{{time}}秒后可重发</div>
                                </template>
                            </el-input>
                        </el-form-item>

                        <el-form-item label="" prop="agreement">
                            <el-checkbox-group v-model="ruleForm.agreement">
                                <el-checkbox v-model="checked" >我已同意<a href="#">用户须知</a></el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>

                        <el-button type="info" @click="register" :disabled="reg_status">注 册</el-button>
                    </el-tab-pane>
                    </el-tabs>
                </el-form>

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
                    activeName: 'second',
                    dialogVisible: false,
                    dialogInfo:'',
                    time:60,
                    checked:false,
                    reg_status:false,
                    ruleForm:{
                        account:'',
                        password:'',
                        captcha:'',
                        vercode:'',
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
                login:function(){},
                register:function(){

                        this.$refs['ruleForm'].validate(function(valid){
                            if (valid) {
                                axios.post('{{url('/Passport/captcha')}}').then(function(result){

                                });
                            }
                        });

                },
            }
        })

    </script>
@endsection
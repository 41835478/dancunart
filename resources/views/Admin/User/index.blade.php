@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <section>

                <input type="text" name="keywords" class="textbox" placeholder="关键词..." value="{{$key}}"/>
                <input type="button" value="查询" class="group_btn" id="search"/>
                <input type="button" value="重置" onClick="window.location.href='{{URL::to('admin/user')}}'" class="group_btn"/>

            </section>
            <hr />
            <section>
                <div class="page_title">
                    <a class="fr top_rt_btn" onClick="window.location.href='{{URL::to('admin/user/create')}}'">新增用户</a>
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>用户账号</th>
                        <th>用户昵称</th>
                        <th>用户具体信息</th>
                        <th>是否绑定微信</th>
                        <th>可用余额（元）</th>
                        <th>充值次数</th>
                        <th>参与竞拍次数</th>
                        <th>成功拍得次数</th>
                        <th>拍得未付款次数</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>{{ $rs->account }}</td>
                            <td>{{ $rs->nick }}</td>
                            <td>
                                手机：{{ $rs->mob }}<br />
                                邮箱：{{ $rs->email }}
                            </td>
                            <td>@if($rs->wechat_openid == '') 未绑定 @else 已绑定 @endif</td>
                            <td>{{ $rs->user_cash/100 }}元</td>
                            <td>{{ $rs->user_exchange_count }}次</td>
                            <td>{{ $rs->user_auction_count }}次</td>
                            <td>{{ $rs->user_auction_deal }}次</td>
                            <td>{{ $rs->user_auction_not_deal }}次</td>
                            <td>@if($rs->status == '') 冻结 @else 正常 @endif</td>
                            <td>
                                <a href="{{URL::to('admin/user')}}/{{ $rs->id }}/edit">修改</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </section>
        </div>
    </section>

@endsection
@section('footer')
    </body>
    </html>
@endsection
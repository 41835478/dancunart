@extends('Admin.app')
@section('content')
    <section class="rt_wrap content mCustomScrollbar">
        <div class="rt_content">
            <h1>{{$title}}</h1>
            <hr />
            <section>
                <div class="page_title">
                </div>
                <table class="table">
                    <tr>
                        <th>编号</th>
                        <th>账户状态</th>
                        <th>支付宝账户</th>
                        <th>支付宝真实姓名</th>

                        <th>开户人</th>
                        <th>开户银行</th>
                        <th>卡号</th>
                        <th>省份、城市</th>
                        <th>支行名称</th>

                        <th>默认</th>

                        <th>创建时间</th>
                        <th>修改时间</th>
                    </tr>

                    @foreach ($data as $key=>$rs)
                        <tr>
                            <td>{{ $rs->id }}</td>
                            <td>@if($rs->flag) 银行卡 @else 支付宝 @endif</td>

                            <td>{{ $rs->alipay_account }}</td>
                            <td>{{ $rs->alipay_realname }}</td>

                            <td>{{ $rs->bank_payee }}</td>
                            <td>{{ $rs->bank_name }}</td>
                            <td>{{ $rs->accountnumber }}</td>
                            <td>{{ $rs->province }}、{{ $rs->city }}</td>
                            <td>{{ $rs->branchname }}</td>

                            <td>@if($rs->status) 默认 @else - @endif</td>

                            <td>{{ $rs->created_at }}</td>
                            <td>{{ $rs->updated_at }}</td>
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
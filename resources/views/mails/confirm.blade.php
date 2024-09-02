@extends('layout.mail')
@section('head')
    Access Prem's Privileged Club Membership via Mobile App
@endsection
@section('content')
    <table class="header-row" width="508" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
        <tbody>
            <tr>
                <td class="header-row-td" width="508" style=" line-height: 19px; color: #353535; font-size: 14px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Dear {{$name}},</td>
            </tr>
        </tbody>
    </table>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;">
        We are pleased to inform that you are now our esteemed member of Prem's Privileged Club.You can now access your account using our new Android/iOS app with your registered email and system generated OTP to enjoy exclusive features and benefits on the go.
        
        </div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 15px;">If you have any questions or need further assistance, we're here to help!</div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 18px;">If you have any questions/suggestions or wish to get
further involved, please feel free to write to us at <strong>premscollectionskolkata@gmail.com</strong> .
</div>
@endsection

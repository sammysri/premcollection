@extends('layout.mail')
@section('head')
    Send OTP
@endsection
@section('content')
    <table class="header-row" width="508" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
        <tbody>
            <tr>
                <td class="header-row-td" width="508" style=" line-height: 19px; color: #353535; font-size: 14px; padding-bottom: 10px; padding-top: 15px;" valign="top" align="left">Hi,</td>
            </tr>
        </tbody>
    </table>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;">Welcome to the Prems Priviledged Club. To login with your email address, please use the following One-Time Password (OTP):</div>
    <div style="width: 100%; line-height: 45px; color: #353535; font-size: 30px;font-weight: 700;margin: 10px 0; padding: 15px 0;">{{$otp}}</div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 15px;">Please enter this OTP on the verification page. This password can only be used once.</div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 18px;">If you did not request this email verification, please ignore this email or contact us at premscollectionskolkata@gmail.com if you have any concerns.</div>
@endsection
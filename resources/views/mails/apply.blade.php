@extends('layout.mail')
@section('head')
    Thank you for applying for Prem's Privileged Club Membership 
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
        Thank you for submitting your application to Prem's Privileged Club Membership. We appreciate your interest and the time you took to apply. Our team will review your application carefully and will get back to you shortly.
        
        </div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 15px;">If you have any questions in the meantime, please don't hesitate to reach out to us. We look forward to the possibility of working together.</div>
    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 18px;">If you have any questions/suggestions or wish to get
further involved, please feel free to write to us at <strong>premscollectionskolkata@gmail.com</strong> .
</div>
@endsection

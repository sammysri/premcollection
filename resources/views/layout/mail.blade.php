<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('head')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body{
            margin: 0;
            margin-top: 30px;
            padding: 0;
            background-color: #f0f6f6;
            font-family: "Inter", sans-serif;
        }
        @media only screen and (max-width: 776px) {
            .table-td-wrap{
                width: 100%;
            }
        }
        
    </style>
  </head>
  <body>
    <table width="100%" height="100%" bgcolor="#f0f6f6" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td width="100%" align="center" valign="top" bgcolor="#f0f6f6" style="background-color:#f0f6f6; min-height: 200px; margin-top:30px;">
                    <table>
                        <tbody>
                            <tr>
                                <td class="table-td-wrap" align="center" width="600">
    
    
    
                                    <table class="table-row" width="580" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; border-radius: 3px;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td class="table-row-td" height="30px" bgcolor="transparent" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; height: 30px; padding-left: 24px; padding-right: 24px; background-color: transparent;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="532" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style=" line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-row-td" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; padding-left: 24px; padding-right: 24px;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="532" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="532" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal;" valign="top" align="left">
                                                                    <div style=" line-height: 19px; color: #353535; font-size: 14px; text-align: center;margin-bottom: 30px;">
                                                                        <img src="https://i.ibb.co/NWs51mL/logo-ppc-yellow.png" style="border: 0px none #353535; vertical-align: middle; display: block; padding-bottom: 9px;width: 180px;" hspace="0" vspace="0" border="0">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-row-td" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; padding-left: 28px; padding-right: 28px;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="508" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="508" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal;" valign="top" align="left">
                                                                    @yield('content')
                                                                    
                                                                    <div style="width: 100%; line-height: 19px; color: #353535; font-size: 14px;margin-bottom: 18px;">Thank you, <br>Regards,<br/> Prems Priviledged Club,</div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="table-row-td" height="30px" bgcolor="transparent" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; height: 30px; padding-left: 24px; padding-right: 24px; background-color: transparent;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="532" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style=" line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table-row" width="600" bgcolor="transparent" style="table-layout: fixed; background-color: transparent;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td class="table-row-td" height="30px" bgcolor="transparent" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; height: 30px; padding-left: 24px; padding-right: 24px; background-color: transparent;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="532" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style=" line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table-row" width="600" bgcolor="transparent" style="table-layout: fixed; background-color: transparent;" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td class="table-row-td" height="45px" bgcolor="transparent" style=" line-height: 19px; color: #353535; font-size: 14px; font-weight: normal; height: 45px; padding-left: 24px; padding-right: 24px; background-color: transparent;" valign="top" align="left">
                                                    <table class="table-col" align="left" width="532" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style=" line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    <span style=" line-height: 19px; color: #919191; font-size: 12px;">Do not reply to this email.</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style=" line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    <span style=" line-height: 19px; color: #919191; font-size: 12px;">Need help? Email us: <a href="mailto:premscollectionskolkata@gmail.com" style="color: #919191; text-decoration: none;">premscollectionskolkata@gmail.com</a></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="table-col-td" width="532" align="center" style="padding-top: 10px; line-height: 19px; color: #353535; font-size: 12px; font-weight: normal; text-align: center;" valign="top">
                                                                    <span style=" line-height: 19px; color: #919191; font-size: 12px;">{{now()->year}} <u>Prems Priviledged Club</u> | All Rights Reserved</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
  </body>
</html>
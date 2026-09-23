<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 480px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #047857;
            padding: 24px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            color: #ffffff;
            font-size: 18px;
            letter-spacing: 0.5px;
        }
        .body {
            padding: 32px 28px;
            text-align: center;
        }
        .otp-box {
            background-color: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 16px 24px;
            margin: 24px auto;
            display: inline-block;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #0f172a;
        }
        .notice {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
            margin-top: 16px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 16px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <div class="container">
                    <div class="header">
                        <h2>Task Manager Security++***++</h2>
                    </div>
                    <div class="body">
                        <p style="font-size: 15px; margin-top: 0; color: #1e293b;">
                            Use the verification code below to complete your request:
                        </p>

                        <div class="otp-box">
                            {{ $otp }}
                        </div>

                        <p class="notice">
                            This code is valid for <strong>10 minutes</strong>.<br>
                            If you did not request this code, you can safely ignore this email.
                        </p>
                    </div>
                    <div class="footer">
                        This is an automated message, please do not reply.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
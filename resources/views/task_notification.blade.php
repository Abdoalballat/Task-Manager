<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Task Notification' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-collapse: collapse;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #068a5e;
            padding: 28px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .body-content {
            padding: 32px 28px;
        }
        .task-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #10b981;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .task-title {
            font-size: 16px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-in_progress { background-color: #e0f2fe; color: #0369a1; }
        .badge-completed { background-color: #d1fae5; color: #065f46; }
        .btn-action {
            display: inline-block;
            padding: 11px 24px;
            background-color: #10b981;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 15px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center">
                <div class="email-container">
                    
                    {{-- Header --}}
                    <div class="header">
                        <h1>Task Manager Workspace</h1>
                    </div>

                    {{-- Body --}}
                    <div class="body-content">
                        <p style="font-size: 15px; margin-top: 0;">
                            Hello <strong>{{ $task->user->name ?? 'Team Member' }}</strong>,
                        </p>
                        
                        <p style="font-size: 14px; color: #64748b; line-height: 1.6;">
                            A new task has been assigned to you or an update requires your attention:
                        </p>

                        {{-- Task Details Card --}}
                        <div class="task-card">
                            <div class="task-title">{{ $task->title ?? 'New Task Assignment' }}</div>
                            
                            @if(!empty($task->description))
                                <p style="font-size: 13px; color: #64748b; margin: 6px 0 12px 0;">
                                    {{ $task->description }}
                                </p>
                            @endif

                            <table width="100%" style="font-size: 13px; margin-top: 10px;">
                                <tr>
                                    <td width="30%" style="color: #64748b; padding: 4px 0;">Priority:</td>
                                    <td style="font-weight: 600; padding: 4px 0;">{{ ucfirst($task->priority ?? 'Medium') }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Status:</td>
                                    <td style="padding: 4px 0;">
                                        <span class="badge badge-{{ $task->status ?? 'pending' }}">
                                            {{ str_replace('_', ' ', ucfirst($task->status ?? 'Pending')) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Deadline:</td>
                                    <td style="padding: 4px 0; color: #ef4444; font-weight: 500;">
                                        {{ $task->deadline ?? 'No fixed deadline' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        {{-- CTA Button --}}
                        <div style="text-align: center; margin-top: 25px;">
                            <a href="{{ route('my_tasks') }}" class="btn-action">
                                View My Tasks
                            </a>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="footer">
                        This is an automated notification from your Task Manager System.<br>
                        Please do not reply directly to this email.
                    </div>

                </div>
            </td>
        </tr>
    </table>
</body>
</html>
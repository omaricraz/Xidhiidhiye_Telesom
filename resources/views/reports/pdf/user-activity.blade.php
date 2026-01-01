<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Activity Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Activity Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
        <p>Period: {{ date('M d, Y', strtotime($dateFrom)) }} to {{ date('M d, Y', strtotime($dateTo)) }}</p>
    </div>

    <div style="margin-bottom: 20px; padding: 15px; background-color: #f5f5f5; border-radius: 5px;">
        <h3 style="margin-top: 0; color: #333;">Report Overview</h3>
        <p style="color: #666; margin-bottom: 0;">This report shows user engagement metrics including tasks created, tasks completed, and questions asked during the selected period. The Total Activity column provides an overall engagement score for each user.</p>
    </div>

    <div style="margin-top: 20px; margin-bottom: 15px;">
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 5px;">User Activity Details</h3>
        <p style="color: #666; margin-top: 5px;">Detailed breakdown of each user's activity including their role, team assignment, and individual contribution metrics.</p>
        <p style="color: #999; font-size: 11px; margin-top: 5px; margin-bottom: 0;">
            <strong>Column Descriptions:</strong> User Name - Full name of the user | Email - User's email address | Role - User's role in the system | 
            Team - Team the user belongs to | Tasks Created - Number of tasks created in the period | Tasks Completed - Number of tasks completed in the period | 
            Questions Asked - Number of questions posted | Total Activity - Sum of all activity metrics (created + completed + questions)
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Team</th>
                <th>Tasks Created</th>
                <th>Tasks Completed</th>
                <th>Questions Asked</th>
                <th>Total Activity</th>
            </tr>
        </thead>
        <tbody>
            @forelse($userActivityData as $activity)
            <tr>
                <td>{{ $activity['user']->name }}</td>
                <td>{{ $activity['user']->email }}</td>
                <td>{{ $activity['user']->role }}</td>
                <td>{{ $activity['user']->team ? $activity['user']->team->name : 'N/A' }}</td>
                <td>{{ $activity['tasks_created'] }}</td>
                <td>{{ $activity['tasks_completed'] }}</td>
                <td>{{ $activity['questions_asked'] }}</td>
                <td><strong>{{ $activity['total_activity'] }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">No user activity found for the selected period.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Learning Progress Report</title>
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
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
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
        .completion-rate {
            font-weight: bold;
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
        <h1>Learning Progress Report</h1>
        <p>Generated on: {{ date('F d, Y h:i A') }}</p>
        <p>Period: {{ date('M d, Y', strtotime($dateFrom)) }} to {{ date('M d, Y', strtotime($dateTo)) }}</p>
    </div>

    <div class="summary">
        <h3>Overall Statistics</h3>
        <p style="color: #666; margin-bottom: 15px;">Summary of learning progress across all goals and teams showing overall completion rates and participation metrics.</p>
        <p><strong>Total Progress Records:</strong> {{ $totalProgress }}</p>
        <p><strong>Completed:</strong> {{ $completedProgress }}</p>
        <p><strong>Overall Completion Rate:</strong> {{ $overallCompletionRate }}%</p>
    </div>

    <div style="margin-top: 30px; margin-bottom: 15px;">
        <h3 style="color: #333; border-bottom: 2px solid #333; padding-bottom: 5px;">Learning Goals Progress</h3>
        <p style="color: #666; margin-top: 5px;">Detailed progress for each learning goal showing how many users have enrolled, completed, and the completion rate per goal. Goals are organized by team assignment.</p>
        <p style="color: #999; font-size: 11px; margin-top: 5px; margin-bottom: 0;">
            <strong>Column Descriptions:</strong> Goal Title - Name of the learning goal | Description - Brief description of what the goal entails | 
            Team - Team assigned to this goal (Global means available to all) | Total Users - Number of users enrolled in this goal | 
            Completed Users - Number of users who have completed this goal | Completion Rate - Percentage of enrolled users who completed the goal
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Goal Title</th>
                <th>Description</th>
                <th>Team</th>
                <th>Total Users</th>
                <th>Completed Users</th>
                <th>Completion Rate (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($progressStats as $stat)
            <tr>
                <td>{{ $stat['goal']->title }}</td>
                <td>{{ Str::limit($stat['goal']->description, 50) }}</td>
                <td>{{ $stat['goal']->team ? $stat['goal']->team->name : 'Global' }}</td>
                <td>{{ $stat['total_users'] }}</td>
                <td>{{ $stat['completed_users'] }}</td>
                <td class="completion-rate">{{ $stat['completion_rate'] }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">No learning goals found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the system.</p>
    </div>
</body>
</html>


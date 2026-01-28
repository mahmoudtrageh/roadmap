<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day {{ $day }}: {{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 40px;
            background: #f8f9fa;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
        }

        .header h1 {
            color: #1e40af;
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header .day-number {
            background: #3b82f6;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            display: inline-block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .header h2 {
            color: #64748b;
            font-size: 20px;
            font-weight: 600;
            margin-top: 10px;
            direction: rtl;
            unicode-bidi: embed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        tbody td {
            padding: 12px 15px;
            font-size: 13px;
        }

        tbody td:first-child {
            font-weight: 600;
            color: #1e40af;
        }

        tbody td:nth-child(2) {
            font-weight: 600;
            color: #059669;
            direction: rtl;
            text-align: right;
            unicode-bidi: embed;
        }

        tbody td:last-child {
            font-family: 'Courier New', monospace;
            background: #f1f5f9;
            color: #475569;
            border-radius: 4px;
            padding: 8px 12px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .footer .logo {
            font-weight: 700;
            color: #3b82f6;
            font-size: 14px;
            margin-bottom: 5px;
        }

        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="day-number">Day {{ $day }}</div>
        <h1>{{ $title }}</h1>
        <h2>{{ $titleAr }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30%;">English Term</th>
                <th style="width: 30%;">Arabic Translation</th>
                <th style="width: 40%;">Example</th>
            </tr>
        </thead>
        <tbody>
            @foreach($terms as $term)
            <tr>
                <td>{{ $term['english'] }}</td>
                <td>{{ $term['arabic'] }}</td>
                <td><code>{{ $term['example'] }}</code></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="logo">Roadmap.camp - Full Stack Developer Learning Path</div>
        <div>Technical Terms Translation Series</div>
        <div style="margin-top: 10px;">© {{ date('Y') }} - Learn. Build. Succeed.</div>
    </div>
</body>
</html>

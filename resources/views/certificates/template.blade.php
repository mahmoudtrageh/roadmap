<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
        }

        .certificate {
            background: white;
            padding: 60px 80px;
            border: 20px solid #f8f9fa;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 3px solid #667eea;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 48px;
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .header p {
            font-size: 18px;
            color: #6c757d;
            font-style: italic;
        }

        .body {
            margin: 40px 0;
        }

        .awarded-to {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .student-name {
            font-size: 56px;
            color: #212529;
            font-weight: bold;
            margin: 20px 0;
            border-bottom: 3px solid #667eea;
            display: inline-block;
            padding-bottom: 10px;
        }

        .completion-text {
            font-size: 18px;
            color: #495057;
            margin: 30px 0;
            line-height: 1.8;
        }

        .roadmap-title {
            font-size: 32px;
            color: #667eea;
            font-weight: bold;
            margin: 20px 0;
        }

        .roadmap-description {
            font-size: 16px;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .date-section, .verification-section {
            flex: 1;
        }

        .date-section {
            text-align: left;
        }

        .verification-section {
            text-align: right;
        }

        .label {
            font-size: 14px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .value {
            font-size: 18px;
            color: #212529;
            font-weight: bold;
        }

        .verification-code {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            color: #667eea;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .seal {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>CERTIFICATE</h1>
            <p>of Completion</p>
        </div>

        <div class="body">
            <div class="awarded-to">This Certificate is Proudly Presented to</div>

            <div class="student-name">{{ $student_name }}</div>

            <div class="completion-text">
                For successfully completing the
            </div>

            <div class="roadmap-title">{{ $roadmap_title }}</div>

            <div class="roadmap-description">
                {{ $roadmap_description }}
            </div>

            <div class="completion-text">
                Demonstrating dedication, perseverance, and mastery of the required skills and knowledge.
            </div>
        </div>

        <div class="footer">
            <div class="date-section">
                <div class="label">Date of Completion</div>
                <div class="value">{{ $completion_date }}</div>
            </div>

            <div class="verification-section">
                <div class="label">Verification Code</div>
                <div class="verification-code">{{ $verification_code }}</div>
            </div>
        </div>

        <div class="seal">
            VERIFIED
        </div>
    </div>
</body>
</html>

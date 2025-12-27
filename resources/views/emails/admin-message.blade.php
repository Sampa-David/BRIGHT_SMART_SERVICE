<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .message-box {
            background-color: #f9f9f9;
            border-left: 4px solid #FF6B6B;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
            line-height: 1.6;
            color: #333;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #FF6B6B 0%, #4ECDC4 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Bonjour <strong>{{ $contact->name }}</strong>,
            </div>

            <p>
                L'équipe d'administration de <strong>{{ config('app.name') }}</strong> vous a envoyé un message :
            </p>

            <div class="message-box">
                {!! nl2br(e($contact->message)) !!}
            </div>

            <p>
                Nous restons à votre disposition pour toute question ou demande d'information.
            </p>

            <p>
                Cordialement,<br>
                <strong>L'équipe {{ config('app.name') }}</strong>
            </p>
        </div>

        <div class="footer">
            <p>
                © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.<br>
                Cet email a été envoyé à {{ $contact->email }}
            </p>
        </div>
    </div>
</body>
</html>

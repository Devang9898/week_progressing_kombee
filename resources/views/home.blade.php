<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 0 20px;
        }

        .dashboard-container {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .user-info {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .user-info p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .btn-logout {
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .footer {
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome to Your Dashboard</h1>
        
        <!-- User Information Section -->
        <div class="user-info">
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>

        <!-- Footer Section -->
        <div class="footer">
            <p>Logged in as <strong>{{ Auth::user()->name }}</strong></p>
        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            overflow-x: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Decorative floating orbs behind the glass */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: 0;
            pointer-events: none;
        }

        body::before {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #ff6b6b, #feca57);
            top: -100px;
            left: -100px;
        }

        body::after {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #48dbfb, #0abde3);
            bottom: -150px;
            right: -150px;
        }

        h1 {
            position: relative;
            z-index: 1;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: rgba(255, 255, 255, 0.95);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        /* Glass container */
        .glass-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            border-radius: 24px;
            padding: 3px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.6) 0%,
                rgba(255, 255, 255, 0.1) 40%,
                rgba(255, 255, 255, 0.05) 60%,
                rgba(255, 255, 255, 0.3) 100%
            );
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.12),
                0 2px 8px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(255, 255, 255, 0.1);
        }

        .glass-inner {
            border-radius: 22px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0.08) 50%,
                rgba(255, 255, 255, 0.15) 100%
            );
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            overflow: hidden;
        }

        /* Top reflection highlight */
        .glass-inner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.2) 0%,
                rgba(255, 255, 255, 0.0) 100%
            );
            border-radius: 22px 22px 0 0;
            pointer-events: none;
            z-index: 2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 1;
        }

        thead tr {
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0.1) 100%
            );
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        th {
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            transition: background 0.3s ease;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        td {
            padding: 16px 20px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* Subtle scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }

            th, td {
                padding: 12px 10px;
                font-size: 0.8rem;
            }

            .glass-container {
                border-radius: 16px;
            }

            .glass-inner {
                border-radius: 14px;
            }
        }
    </style>
</head>
<body>

    <h1>Users List</h1>

    <div class="glass-container">
        <div class="glass-inner">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['firstname']) ?></td>
                            <td><?= htmlspecialchars($user['lastname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
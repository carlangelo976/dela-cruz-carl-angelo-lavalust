<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f7;
            color: #1a1a1a;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* ── Colored header ── */
        .page-header {
            background: #4f46e5;
            color: #fff;
            border-radius: 12px;
            padding: 28px 28px 26px;
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .page-header p {
            font-size: 13px;
            opacity: 0.8;
        }

        .page-header .count {
            float: right;
            background: rgba(255,255,255,0.2);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        /* ── Table ── */
        .table-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4f46e5;
            background: #eef2ff;
            border-bottom: 1px solid #dde0ff;
        }

        td {
            padding: 14px 20px;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #f5f6ff;
        }

        /* ── Avatar circle with initials ── */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .av-0 { background: #4f46e5; }  /* indigo   */
        .av-1 { background: #0d9488; }  /* teal     */
        .av-2 { background: #d97706; }  /* amber    */
        .av-3 { background: #be123c; }  /* rose     */
        .av-4 { background: #7c3aed; }  /* violet   */

        .id-num {
            color: #4f46e5;
            font-weight: 600;
        }

        .username {
            background: #eef2ff;
            color: #4f46e5;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .email {
            color: #666;
        }

        .empty {
            padding: 40px 20px;
            text-align: center;
            color: #999;
        }

        footer {
            margin-top: 24px;
            text-align: center;
            font-size: 12px;
            color: #aaa;
        }

        /* ── Mobile: stack rows ── */
        @media (max-width: 640px) {
            thead { display: none; }

            tbody tr {
                display: block;
                padding: 16px 20px;
                border-bottom: 1px solid #e5e5e5;
            }

            tbody tr:last-child { border-bottom: none; }

            td {
                display: flex;
                justify-content: space-between;
                padding: 4px 0;
                border: none;
                text-align: right;
            }

            td::before {
                content: attr(data-label);
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
                color: #999;
                margin-right: 12px;
            }

            .user-cell { justify-content: flex-end; }
            .id-num { text-align: right; }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- Colored header -->
        <div class="page-header">
            <span class="count"><?= count($users) ?> users</span>
            <h1>Users</h1>
            <p>Registered users of the platform</p>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td class="empty" colspan="4">No users found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td data-label="ID"><span class="id-num"><?= htmlspecialchars($user['id']) ?></span></td>
                            <td data-label="Name">
                                <div class="user-cell">
                                    <span class="avatar av-<?= $index % 5 ?>">
                                        <?= htmlspecialchars(strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1))) ?>
                                    </span>
                                    <?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?>
                                </div>
                            </td>
                            <td data-label="Email" class="email"><?= htmlspecialchars($user['email']) ?></td>
                            <td data-label="Username"><span class="username"><?= htmlspecialchars($user['username']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <footer>&copy; <?= date('Y') ?> All rights reserved.</footer>
    </div>

</body>
</html>
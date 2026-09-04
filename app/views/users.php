<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        /* ── Google Font ── */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+3:wght@400;600;700&display=swap');

        /* ── CSS Variables ── */
        :root {
            --desk-from: #5c4a3a;
            --desk-to: #3b2e22;
            --leather-from: #2e2320;
            --leather-to: #1a1412;
            --gold: #c9a84c;
            --gold-dim: #8a7233;
            --paper: #f5eed6;
            --paper-edge: #e6d9b8;
            --ink: #2c1e10;
            --ink-light: #6b5740;
            --row-even: rgba(255,255,255,0.06);
            --row-hover: rgba(201,168,76,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            font-family: 'Source Sans 3', Georgia, serif;
            color: var(--ink);

            /* ── Wooden Desk Surface ── */
            background:
                /* subtle wood grain lines */
                repeating-linear-gradient(
                    87deg,
                    transparent,
                    transparent 2px,
                    rgba(0,0,0,0.03) 2px,
                    rgba(0,0,0,0.03) 4px
                ),
                /* desk gradient */
                linear-gradient(160deg, var(--desk-from) 0%, var(--desk-to) 100%);
            background-attachment: fixed;
        }

        /* ── Main Card (Leather Portfolio) ── */
        .portfolio {
            width: 100%;
            max-width: 900px;
            border-radius: 16px;
            padding: 48px 44px 52px;

            /* leather gradient */
            background:
                /* stitch-line texture */
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 28px,
                    rgba(201,168,76,0.04) 28px,
                    rgba(201,168,76,0.04) 29px
                ),
                radial-gradient(
                    ellipse at 30% 20%,
                    rgba(201,168,76,0.08) 0%,
                    transparent 60%
                ),
                linear-gradient(170deg, var(--leather-from) 0%, var(--leather-to) 100%);

            /* raised surface — key skeuomorphism technique */
            box-shadow:
                /* outer drop shadow (lifted off desk) */
                0 22px 60px rgba(0,0,0,0.55),
                0 4px 16px rgba(0,0,0,0.35),
                /* top-left highlight rim */
                inset 0 1.5px 0 rgba(255,255,255,0.08),
                /* bottom-right inner shadow (depth) */
                inset 0 -2px 4px rgba(0,0,0,0.25),
                /* subtle inner glow */
                inset 0 0 80px rgba(0,0,0,0.12);

            border: 1px solid rgba(201,168,76,0.15);
            position: relative;
        }

        /* ── Gold embossed border ring ── */
        .portfolio::before {
            content: '';
            position: absolute;
            inset: 8px;
            border-radius: 10px;
            border: 1.5px solid rgba(201,168,76,0.12);
            pointer-events: none;
        }

        /* ── Title ── */
        h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--gold);
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 36px;

            /* embossed / pressed-in text effect */
            text-shadow:
                0 1px 0 rgba(0,0,0,0.6),
                0 -1px 0 rgba(255,255,255,0.08);

            position: relative;
        }

        /* decorative rule under title */
        h1::after {
            content: '';
            display: block;
            margin: 14px auto 0;
            width: 180px;
            height: 2px;
            border-radius: 1px;
            background: linear-gradient(
                90deg,
                transparent 0%,
                var(--gold-dim) 20%,
                var(--gold) 50%,
                var(--gold-dim) 80%,
                transparent 100%
            );
            box-shadow: 0 1px 3px rgba(201,168,76,0.25);
        }

        /* ── Table Container (Paper Sheet) ── */
        .paper-sheet {
            border-radius: 8px;
            overflow: hidden;

            /* paper surface */
            background:
                /* subtle paper fiber texture */
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 1px,
                    rgba(0,0,0,0.008) 1px,
                    rgba(0,0,0,0.008) 2px
                ),
                linear-gradient(175deg, var(--paper) 0%, var(--paper-edge) 100%);

            /* paper lifted off leather */
            box-shadow:
                0 8px 28px rgba(0,0,0,0.35),
                0 2px 6px rgba(0,0,0,0.22),
                inset 0 1px 0 rgba(255,255,255,0.6),
                inset 0 -1px 0 rgba(0,0,0,0.05);

            border: 1px solid rgba(0,0,0,0.08);
        }

        /* ── Table Reset ── */
        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        /* ── Header Row ── */
        thead tr {
            background:
                linear-gradient(
                    180deg,
                    #4a3d30 0%,
                    #3a2f24 60%,
                    #2e241b 100%
                );
        }

        thead th {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: var(--gold);
            padding: 16px 20px;
            text-align: left;

            /* beveled header cell */
            border-right: 1px solid rgba(0,0,0,0.18);
            border-bottom: 1px solid rgba(0,0,0,0.3);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.08),
                inset 0 -1px 0 rgba(0,0,0,0.15);

            /* pressed-in label */
            text-shadow:
                0 1px 2px rgba(0,0,0,0.5),
                0 -1px 0 rgba(255,255,255,0.06);
        }

        thead th:last-child { border-right: none; }

        /* ── Body Rows ── */
        tbody tr {
            transition: background 0.2s ease, box-shadow 0.2s ease;
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }

        tbody tr:nth-child(even) {
            background: var(--row-even);
        }

        tbody tr:hover {
            background: var(--row-hover);
            /* subtle lift on hover */
            box-shadow:
                0 2px 8px rgba(0,0,0,0.08),
                inset 0 1px 0 rgba(255,255,255,0.25);
        }

        tbody td {
            font-family: 'Source Sans 3', sans-serif;
            font-size: 15px;
            font-weight: 400;
            color: var(--ink);
            padding: 14px 20px;

            border-right: 1px solid rgba(0,0,0,0.05);

            /* slightly inked text */
            text-shadow: 0 0 1px rgba(44,30,16,0.15);
        }

        tbody td:last-child { border-right: none; }

        /* ── ID column: monospaced for numbers ── */
        tbody td:first-child {
            font-weight: 600;
            color: var(--ink-light);
            font-variant-numeric: tabular-nums;
        }

        /* ── Email column: muted ── */
        tbody td:nth-child(4) {
            color: var(--ink-light);
            font-size: 14px;
        }

        /* ── Responsive ── */
        @media (max-width: 700px) {
            .portfolio { padding: 28px 16px 36px; }
            h1 { font-size: 24px; letter-spacing: 1px; }
            thead th, tbody td { padding: 10px 12px; font-size: 13px; }
            thead th { font-size: 11px; letter-spacing: 1px; }
        }

        /* ── Subtle entrance animation ── */
        @keyframes settle {
            0%   { opacity: 0; transform: translateY(18px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .portfolio {
            animation: settle 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @media (prefers-reduced-motion: reduce) {
            .portfolio { animation: none; }
        }
    </style>
</head>
<body>

    <div class="portfolio">

        <h1>Users List</h1>

        <div class="paper-sheet">
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
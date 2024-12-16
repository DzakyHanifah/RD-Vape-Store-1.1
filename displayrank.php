
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .podium {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 20px;
            margin: 50px 0;
        }
        .podium div {
            text-align: center;
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            width: 150px;
        }
        .podium .second {
            height: 150px;
        }
        .podium .first {
            height: 200px;
            background-color: #ffd700; /* Gold */
        }
        .podium .third {
            height: 120px;
        }
        .ranking-table {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-5">Ranking Member</h1>

        <!-- Podium -->
        <div class="podium">
            <?php if (count($members) > 1): ?>
                <div class="second">
                    <h3>#2</h3>
                    <p><strong><?= htmlspecialchars($members[1]['name']); ?></strong></p>
                    <p><?= htmlspecialchars($members[1]['total_points']); ?> Points</p>
                </div>
            <?php endif; ?>

            <?php if (count($members) > 0): ?>
                <div class="first">
                    <h3>#1</h3>
                    <p><strong><?= htmlspecialchars($members[0]['name']); ?></strong></p>
                    <p><?= htmlspecialchars($members[0]['total_points']); ?> Points</p>
                </div>
            <?php endif; ?>

            <?php if (count($members) > 2): ?>
                <div class="third">
                    <h3>#3</h3>
                    <p><strong><?= htmlspecialchars($members[2]['name']); ?></strong></p>
                    <p><?= htmlspecialchars($members[2]['total_points']); ?> Points</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Table for Ranking 4 and Beyond -->
        <div class="ranking-table">
            <h2 class="text-center mb-4">Ranking 4 and Beyond</h2>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Points</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 3; $i < count($members); $i++): ?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td><?= htmlspecialchars($members[$i]['name']); ?></td>
                            <td><?= htmlspecialchars($members[$i]['points']); ?></td>
                            <td><?= htmlspecialchars($members[$i]['total_points']); ?></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

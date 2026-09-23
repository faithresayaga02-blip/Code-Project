<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once 'database.php';

// Fetch all registered students
$result = $conn->query("SELECT * FROM students WHERE TRIM(firstname) != '' AND TRIM(lastname) != '' ORDER BY id DESC");
$students = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
$total_students = count($students);

$admin_first = $_SESSION['firstname'] ?? 'Faith';
$admin_last  = $_SESSION['lastname'] ?? 'Resayaga';
$admin_initial = strtoupper(substr($admin_first, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resayaga Workspace &bull; Student Records</title>
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-deep: #160728;
            --surface-panel: #240c42;
            --surface-card: #2f1057;
            --accent-pink: #f43f5e;
            --accent-purple: #c026d3;
            --accent-magenta: #d946ef;
            --text-pure: #ffffff;
            --text-dim: #c084fc;
            --border-glow: rgba(217, 70, 239, 0.25);
            --border-highlight: rgba(217, 70, 239, 0.5);
            --gradient-accent: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-pure);
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(236, 72, 153, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(139, 92, 246, 0.12) 0%, transparent 45%);
            background-attachment: fixed;
            padding: 24px;
        }

        /* Top Bar Capsule */
        .workspace-capsule {
            max-width: 1250px;
            margin: 0 auto 24px auto;
            background: var(--surface-panel);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .brand-gem {
            width: 40px;
            height: 40px;
            background: var(--gradient-accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 0 18px rgba(217, 70, 239, 0.45);
        }

        .user-tag {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-glow);
            padding: 6px 14px 6px 8px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-pill {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--gradient-accent);
            color: white;
            font-weight: 800;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-exit-glow {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.4);
            color: #fb7185;
            padding: 6px 16px;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-exit-glow:hover {
            background: #f43f5e;
            color: white;
            box-shadow: 0 0 15px rgba(244, 63, 94, 0.5);
        }

        /* Two-Column App Layout */
        .workspace-grid {
            max-width: 1250px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
        }

        @media (max-width: 992px) {
            .workspace-grid {
                grid-template-columns: 1fr;
            }
        }

        .panel-box {
            background: var(--surface-panel);
            border: 1px solid var(--border-glow);
            border-radius: 22px;
            padding: 26px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* Form Inputs */
        .input-glow {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glow);
            border-radius: 12px;
            padding: 12px 16px;
            color: #ffffff;
            font-size: 0.92rem;
            outline: none;
            width: 100%;
            transition: all 0.2s;
        }

        .input-glow:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent-magenta);
            box-shadow: 0 0 15px rgba(217, 70, 239, 0.3);
            color: #ffffff;
        }

        .btn-glow-submit {
            background: var(--gradient-accent);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            font-size: 0.92rem;
            width: 100%;
            box-shadow: 0 4px 20px rgba(217, 70, 239, 0.4);
            transition: all 0.2s;
        }

        .btn-glow-submit:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(217, 70, 239, 0.6);
            color: white;
        }

        /* Student Record Row Strips */
        .student-strip {
            background: var(--surface-card);
            border: 1px solid var(--border-glow);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .student-strip:hover {
            border-color: var(--border-highlight);
            transform: translateX(4px);
            box-shadow: 0 4px 18px rgba(217, 70, 239, 0.15);
        }

        .badge-id {
            background: rgba(217, 70, 239, 0.15);
            border: 1px solid rgba(217, 70, 239, 0.3);
            color: #f0abfc;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .btn-action-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border-glow);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-dim);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-action-icon:hover {
            color: #ffffff;
            border-color: var(--accent-magenta);
            background: rgba(217, 70, 239, 0.2);
        }

        .btn-action-icon.del:hover {
            color: #f43f5e;
            border-color: #f43f5e;
            background: rgba(244, 63, 94, 0.2);
        }

        /* Search Box */
        .search-strip-box {
            position: relative;
            width: 100%;
            max-width: 280px;
        }

        .search-strip-box input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-glow);
            border-radius: 50px;
            padding: 8px 14px 8px 36px;
            color: #ffffff;
            font-size: 0.85rem;
            outline: none;
        }

        .search-strip-box input:focus {
            border-color: var(--accent-magenta);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 10px rgba(217, 70, 239, 0.2);
        }

        .search-strip-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
        }

        /* Modal Overrides */
        .modal-glass {
            background: #240c42;
            border: 1px solid var(--border-highlight);
            border-radius: 20px;
            color: white;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body>

    <!-- Top Capsule Bar -->
    <header class="workspace-capsule">
        <div class="d-flex align-items-center gap-3">
            <div class="brand-gem">
                <i class="bi bi-sparkles"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0 text-white">RESAYAGA REPOSITORY</h5>
                <span class="mono" style="font-size: 0.72rem; color: var(--text-dim);">phpcrudresayaga &bull; Active Cluster</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="user-tag d-none d-sm-flex">
                <div class="user-avatar-pill"><?= $admin_initial; ?></div>
                <div class="pe-1">
                    <div class="fw-bold small text-white leading-tight"><?= htmlspecialchars($admin_first . ' ' . $admin_last); ?></div>
                    <div style="font-size: 0.7rem; color: #a855f7;">System Administrator</div>
                </div>
            </div>
            <a href="logout.php" class="btn-exit-glow">
                <i class="bi bi-power me-1"></i> Sign Out
            </a>
        </div>
    </header>

    <!-- Split Grid -->
    <main class="workspace-grid">

        <!-- Left: Quick Entry Terminal -->
        <section class="panel-box">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge rounded-pill bg-magenta" style="background: rgba(217, 70, 239, 0.2); color: #f0abfc; border: 1px solid var(--border-glow); font-size: 0.75rem;">
                    ENROLLMENT DESK
                </span>
                <span class="mono small" style="color: var(--text-dim);">LIVE_INPUT</span>
            </div>

            <h4 class="fw-bold mb-1">New Registration</h4>
            <p class="small mb-4" style="color: var(--text-dim);">Enter student details to commit changes to the database.</p>

            <!-- Alerts -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert border-0 py-2 px-3 mb-3 small rounded-3" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4) !important;">
                    <i class="bi bi-check-circle-fill me-1"></i> <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert border-0 py-2 px-3 mb-3 small rounded-3" style="background: rgba(244, 63, 94, 0.2); color: #fb7185; border: 1px solid rgba(244, 63, 94, 0.4) !important;">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i> <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <form action="insert.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                <div class="mb-3">
                    <label class="form-label small fw-bold" style="color: var(--text-dim);">FIRST NAME</label>
                    <input type="text" name="firstname" class="input-glow" placeholder="e.g. Andrea" maxlength="50" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold" style="color: var(--text-dim);">LAST NAME</label>
                    <input type="text" name="lastname" class="input-glow" placeholder="e.g. Perez" maxlength="50" required>
                </div>

                <button type="submit" class="btn-glow-submit">
                    <i class="bi bi-plus-circle me-1"></i> Save to Database
                </button>
            </form>

            <div class="mt-4 pt-3 border-top" style="border-color: var(--border-glow) !important;">
                <div class="d-flex justify-content-between small" style="color: var(--text-dim);">
                    <span>Total Database Rows:</span>
                    <strong class="text-white mono" id="totalBadge"><?= $total_students; ?></strong>
                </div>
            </div>
        </section>

        <!-- Right: Real-time Records Canvas -->
        <section class="panel-box">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h5 class="fw-bold mb-0">Active Students</h5>
                    <span class="small" style="color: var(--text-dim);">Verified records in system</span>
                </div>

                <div class="search-strip-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="directoryFilter" placeholder="Filter roster...">
                </div>
            </div>

            <!-- List rows -->
            <div id="rosterWrapper">
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <div class="student-strip student-entity-row">
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge-id mono">#<?= str_pad($student['id'], 3, '0', STR_PAD_LEFT); ?></span>
                                <div>
                                    <div class="fw-bold text-white target-name"><?= htmlspecialchars($student['firstname'] . ' ' . $student['lastname']); ?></div>
                                    <div class="small mono" style="font-size: 0.75rem; color: var(--text-dim);">
                                        FN: <?= htmlspecialchars($student['firstname']); ?> | LN: <?= htmlspecialchars($student['lastname']); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#editModal<?= $student['id']; ?>" title="Edit Entry">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                <form action="delete.php" method="POST" onsubmit="return confirm('Permanently remove this record?');" class="m-0">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                                    <input type="hidden" name="id" value="<?= $student['id']; ?>">
                                    <button type="submit" class="btn-action-icon del" title="Delete">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $student['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered text-start">
                                    <div class="modal-content modal-glass p-3">
                                        <form action="update.php" method="POST">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="fw-bold mb-0">Modify Student Entry</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                                                <input type="hidden" name="id" value="<?= $student['id']; ?>">

                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold" style="color: var(--text-dim);">First Name</label>
                                                    <input type="text" name="firstname" class="input-glow" value="<?= htmlspecialchars($student['firstname']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold" style="color: var(--text-dim);">Last Name</label>
                                                    <input type="text" name="lastname" class="input-glow" value="<?= htmlspecialchars($student['lastname']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-outline-light rounded-3 px-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn-glow-submit" style="width: auto; padding: 8px 24px;">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5" style="color: var(--text-dim);">
                        <i class="bi bi-folder-x fs-1 d-block mb-2" style="color: var(--accent-magenta);"></i>
                        <h6 class="fw-bold text-white mb-1">No Entries Recorded</h6>
                        <p class="small mb-0">Use the registration form on the left to start enrolling students.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const search = document.getElementById('directoryFilter');
        const rows = document.querySelectorAll('.student-entity-row');
        const badge = document.getElementById('totalBadge');

        search.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let count = 0;

            rows.forEach(row => {
                const name = row.querySelector('.target-name').textContent.toLowerCase();
                if (name.includes(query)) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (badge) badge.textContent = count;
        });
    </script>
</body>
</html>
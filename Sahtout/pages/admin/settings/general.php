<?php
define('ALLOWED_ACCESS', true);
// Include paths.php using __DIR__ to access $project_root and $base_path
require_once __DIR__ . '/../../../includes/paths.php';
require_once $project_root . 'includes/session.php';
require_once $project_root . 'languages/language.php';
require_once $project_root . 'includes/config.settings.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'moderator'])) {
    header("Location: {$base_path}login");
    exit;
}

$page_class = 'general';
require_once $project_root . 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($langCode); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo translate('page_title_general', 'General Settings'); ?></title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Roboto font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/admin/settings/general.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/admin/admin_sidebar.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/admin/settings/settings_navbar.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <?php include $project_root . 'includes/admin_sidebar.php'; ?>
            <!-- Main Content with Settings Navbar -->
            <main class="col-md-10 main-content">
                <?php include dirname(__DIR__) . '/settings/settings_navbar.php'; ?>
                <div class="content">
                    <h2><?php echo translate('settings_general', 'General Settings'); ?></h2>

                    <!-- Success/Error Messages -->
                    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                        <div class="success-box mb-3 col-md-6 mx-auto">
                            <span class="db-status-icon db-status-success">✔</span>
                            <span class="success"><?php echo translate('msg_settings_saved', 'Settings updated successfully!'); ?></span>
                        </div>
                    <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                        <div class="error-box mb-3 col-md-6 mx-auto">
                            <strong><?php echo translate('err_fix_errors', 'Please fix the following errors:'); ?></strong>
                            <div class="db-status">
                                <span class="db-status-icon db-status-error">❌</span>
                                <span class="error"><?php echo htmlspecialchars(urldecode($_GET['message'])); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- General Settings Form -->
                    <div class="row justify-content-center">
                        <form action="<?php echo $base_path; ?>pages/admin/settings/save_general.php" method="POST" enctype="multipart/form-data" class="col-md-6">
                            <!-- CSRF Token -->
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <!-- Max File Size (3MB) -->
                            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">

                            <!-- Logo Upload -->
                            <div class="mb-3">
                                <label for="logo" class="form-label"><?php echo translate('label_website_logo', 'Website Logo'); ?></label>
                                <div class="mb-2">
                                    <img src="<?php echo htmlspecialchars($site_logo); ?>" alt="<?php echo translate('label_website_logo', 'Website Logo'); ?>" class="img-fluid" style="max-width: 150px;">
                                </div>
                                <div class="custom-file-upload">
                                    <input type="file" id="logo" name="logo" accept="image/png,image/svg+xml,image/jpeg">
                                    <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('logo').click();"><?php echo translate('btn_choose_file', 'Choose File'); ?></button>
                                    <div class="file-name" id="file-name"><?php echo translate('placeholder_logo', 'Upload a PNG, SVG, or JPG image (max 3MB) to be used as your website logo.'); ?></div>
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="mb-3">
                                <label class="form-label"><?php echo translate('label_social_media', 'Social Media Links'); ?></label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-facebook-f"></i></span>
                                    <input type="url" name="facebook" class="form-control" placeholder="<?php echo translate('placeholder_facebook', 'Facebook URL'); ?>" value="<?php echo htmlspecialchars($social_links['facebook'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-x-twitter"></i></span>
                                    <input type="url" name="twitter" class="form-control" placeholder="<?php echo translate('placeholder_twitter', 'Twitter (X) URL'); ?>" value="<?php echo htmlspecialchars($social_links['twitter'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-tiktok"></i></span>
                                    <input type="url" name="tiktok" class="form-control" placeholder="<?php echo translate('placeholder_tiktok', 'TikTok URL'); ?>" value="<?php echo htmlspecialchars($social_links['tiktok'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-youtube"></i></span>
                                    <input type="url" name="youtube" class="form-control" placeholder="<?php echo translate('placeholder_youtube', 'YouTube URL'); ?>" value="<?php echo htmlspecialchars($social_links['youtube'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-discord"></i></span>
                                    <input type="url" name="discord" class="form-control" placeholder="<?php echo translate('placeholder_discord', 'Discord Invite URL'); ?>" value="<?php echo htmlspecialchars($social_links['discord'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-twitch"></i></span>
                                    <input type="url" name="twitch" class="form-control" placeholder="<?php echo translate('placeholder_twitch', 'Twitch URL'); ?>" value="<?php echo htmlspecialchars($social_links['twitch'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><img src="<?php echo $base_path; ?>img/icons/kick-logo.png" alt="Kick" class="kick-icon1"></span>
                                    <input type="url" name="kick" class="form-control" placeholder="<?php echo translate('placeholder_kick', 'Kick URL'); ?>" value="<?php echo htmlspecialchars($social_links['kick'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-instagram"></i></span>
                                    <input type="url" name="instagram" class="form-control" placeholder="<?php echo translate('placeholder_instagram', 'Instagram URL'); ?>" value="<?php echo htmlspecialchars($social_links['instagram'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-github"></i></span>
                                    <input type="url" name="github" class="form-control" placeholder="<?php echo translate('placeholder_github', 'GitHub URL'); ?>" value="<?php echo htmlspecialchars($social_links['github'] ?? ''); ?>">
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-text social-icon"><i class="fab fa-linkedin-in"></i></span>
                                    <input type="url" name="linkedin" class="form-control" placeholder="<?php echo translate('placeholder_linkedin', 'LinkedIn URL'); ?>" value="<?php echo htmlspecialchars($social_links['linkedin'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="btn btn-primary"><?php echo translate('btn_save_settings', 'Save Settings'); ?></button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require_once $project_root . 'includes/footer.php'; ?>
    <script>
        // Update file name display when a file is selected
        document.getElementById('logo').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : '<?php echo translate('placeholder_logo', 'Upload a PNG, SVG, or JPG image (max 3MB) to be used as your website logo.'); ?>';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>
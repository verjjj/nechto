<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lonelywave";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = $_SESSION['role'] ?? null;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LonelyWave - Твой звук в мире шума</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="pulse-text">
            <h1>LonelyWave</h1>
            <p>Где одинокие волны звука становятся океаном музыки</p>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <nav>
                <a href="dashboard.php">Личный кабинет</a>
                <a href="explore.php">Открыть музыку</a>
                <a href="logout.php">Выйти</a>
            </nav>
        <?php else: ?>
            <div class="auth-links">
                <a href="login.php" class="cta-button">Войти в мир звуков</a>
                <a href="register.php" class="cta-button">Стать частью волны</a>
            </div>
        <?php endif; ?>
    </header>

    <main>
        <section class="hero">
            <h2>Твой звук заслуживает быть услышанным</h2>
            <p>Волны твоего творчества могут стать цунами в мире музыки</p>
            
            <?php 
            // Счетчик пользователей и треков
            $users_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
            $tracks_count = $conn->query("SELECT COUNT(*) as count FROM tracks WHERE status = 'approved'")->fetch_assoc()['count'];
            ?>
            
            <div class="collab-counter">
                <p>Уже <strong><?= $users_count ?></strong> музыкантов создали <strong><?= $tracks_count ?></strong> треков на нашей платформе!</p>
                <p>Присоединяйся и найди своих единомышленников</p>
            </div>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="register.php" class="cta-button">Начать звучать</a>
            <?php endif; ?>
        </section>

        <section class="features">
            <div class="feature">
                <h3>Для артистов</h3>
                <p>"Не будь одиноким волком - стань частью стаи"</p>
                <ul>
                    <li>Загружай треки с обложками</li>
                    <li>Делись текстами песен</li>
                    <li>Получай честные отзывы</li>
                </ul>
            </div>
            <div class="feature">
                <h3>Для слушателей</h3>
                <p>"Найди свой саундтрек к жизни"</p>
                <ul>
                    <li>Открывай новые таланты</li>
                    <li>Оценивай и комментируй</li>
                    <li>Создавай плейлисты</li>
                </ul>
            </div>
            <div class="feature">
                <h3>Коллаборации</h3>
                <p>"Вместе мы звучим громче"</p>
                <ul>
                    <li>Находи музыкантов рядом</li>
                    <li>Создавай совместные проекты</li>
                    <li>Организуй джем-сейшены</li>
                </ul>
            </div>
        </section>

        <section class="latest-tracks">
            <h2>Свежие волны в океане звуков</h2>
            <div class="tracks-grid">
                <?php
                $result = $conn->query("SELECT t.*, u.username FROM tracks t JOIN users u ON t.artist_id = u.id WHERE status = 'approved' ORDER BY upload_date DESC LIMIT 6");
                while ($track = $result->fetch_assoc()):
                ?>
                <div class="track-card">
                    <img src="<?= htmlspecialchars($track['cover_path']) ?>" alt="<?= htmlspecialchars($track['title']) ?>">
                    <h4><?= htmlspecialchars($track['title']) ?></h4>
                    <p>Исполнитель: <?= htmlspecialchars($track['username']) ?></p>
                    <a href="track.php?id=<?= $track['id'] ?>">Поймать волну</a>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="quote">
                <p>"Музыка - это язык, который понимают все. Говори на нём свободно."</p>
            </div>
        </section>

        <section class="testimonials">
            <h2>Что говорят наши волноходцы</h2>
            <div class="testimonial">
                <p>"Благодаря LonelyWave я нашёл гитариста для своей группы!"</p>
                <p>- Макс, электронный продюсер</p>
            </div>
            <div class="testimonial">
                <p>"Лучшая платформа для независимых исполнителей!"</p>
                <p>- Аня, вокалистка</p>
            </div>
        </section>
    </main>

    <footer>
        <p>"Один в поле не воин, но в музыке - точно волна"</p>
        <p>&copy; 2023 LonelyWave. Все права защищены.</p>
        <div class="social-links">
            <a href="#">Instagram</a> | 
            <a href="#">Twitter</a> | 
            <a href="#">TikTok</a>
        </div>
    </footer>
</body>
</html>
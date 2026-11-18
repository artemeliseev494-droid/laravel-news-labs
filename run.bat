@echo off
chcp 65001 >nul
echo ===================================================
echo             Запуск новостного сайта
echo ===================================================

if not exist .env (
    copy .env.example .env >nul
    call php artisan key:generate
)

echo Применение миграций базы данных...
call php artisan migrate --seed

if %ERRORLEVEL% neq 0 (
    echo.
    echo [!] Не удалось подключиться к PostgreSQL.
    echo [!] Переключаю подключение на встроенную SQLite...
    powershell -Command "(Get-Content .env) -replace 'DB_CONNECTION=pgsql', 'DB_CONNECTION=sqlite' | Set-Content .env"
    call php artisan migrate --seed
)

echo.
echo Сервер запускается по адресу: http://127.0.0.1:8000
echo Для остановки нажмите Ctrl + C
echo ===================================================
call php artisan serve
pause

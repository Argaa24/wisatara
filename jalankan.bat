@echo off
echo ========================================================
echo   MENJALANKAN SERVER WISATARA (LARAVEL + FILAMENT)
echo ========================================================
echo.
echo Landing Page : http://127.0.0.1:8000
echo Dasbor Admin : http://127.0.0.1:8000/admin
echo.
echo Login Admin:
echo   - Email    : admin@wisatara.com
echo   - Password : admin123
echo.
echo Menjalankan server dengan PHP 8.3...
"C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" artisan serve
pause

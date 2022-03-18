@ECHO OFF
php.exe index.php %*
if NOT ["%errorlevel%"]==["0"] (
    PAUSE
    exit /b %errorlevel%
)
@ECHO OFF
C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -Command "(New-Object System.Net.WebClient).DownloadString('http://localhost/pololender/index.php?min');"
ECHO did it work
PAUSE

while(1)
{
  Get-Date
  echo "Calling Lender.........";
  (New-Object System.Net.WebClient).DownloadString('http://localhost/pololender/index.php?min');
  echo "Done..................."
  echo ""
  start-sleep -seconds 180;
}

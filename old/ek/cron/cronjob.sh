cd /home/astrid/cron/
date=`date +"%d-%m-%Y-%T"`
wget -O output-$date.html http://astrid.ugent.be/wk/mail.php?cronpass=kBBFYXoIO4636BVG
echo "output of mailing of "$date" saved succesfully:"
cat output-$date.html

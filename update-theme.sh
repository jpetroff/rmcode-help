#!/bin/bash

cd ./wp-content/themes/
rm ./rm-help-theme.zip
tar cvf rm-help-theme.tar rm-help-theme
scp ./rm-help-theme.tar john@help-test.readymag.net:~
ssh -t john@help-test.readymag.net << EOF
	sudo cp ~/rm-help-theme.tar /var/www/html/wp-content/themes
	cd  /var/www/html/wp-content/themes
	sudo mv ./rm-help-theme rm-help-theme-old
	sudo tar xvf rm-help-theme.tar
	sudo rm -rf ./rm-help-theme-old
	sudo rm ./rm-help-theme.tar
	sudo chown -R www-data:www-data ./rm-help-theme
EOF
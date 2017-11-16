#!/bin/bash

rm /Users/john/rmsource/rmcode-help/wp-content/themes/rm-help-theme.zip
cd ./wp-content/themes/
tar cvzf rm-help-theme.zip rm-help-theme
scp ./rm-help-theme.zip john@help-test.readymag.net:~
ssh john@help-test.readymag.net

#!/bin/bash

#This is just a little thingy to move it over to the place where it needs to be to host on external
#you'll need webspace and some nonzero experience in front end web development
#mount point has to be set manually

#use this command to make it so stuffs below works
#/usr/bin/sshfs yourusername@173.254.88.123:/home1/machines/ /mnt/machinesentience


cp -r /home/el/bin/bvid/index.php /mnt/machinesentience/public_html/bvid/index.php
cp -r /home/el/bin/bvid/post_increment.php /mnt/machinesentience/public_html/bvid/post_increment.php
#cp -r /home/el/bin/bvid/images/ember.jpg /mnt/machinesentience/public_html/bvid/images/ember.jpg
#cp -r /home/el/bin/bvid/images/universe_is_alive.jpg /mnt/machinesentience/public_html/bvid/images/universe_is_alive.jpg


echo "done"

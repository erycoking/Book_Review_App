---
title: API Reference

language_tabs:
- bash

- javascript


includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>

---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
## api/auth/register
> Example request:

```bash
curl -X POST "http://localhost/api/auth/register" 
```

```javascript
const url = new URL("http://localhost/api/auth/register");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/register`


<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->

<!-- START_a925a8d22b3615f12fca79456d286859 -->
## api/auth/login
> Example request:

```bash
curl -X POST "http://localhost/api/auth/login" 
```

```javascript
const url = new URL("http://localhost/api/auth/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
## api/auth/refresh
> Example request:

```bash
curl -X POST "http://localhost/api/auth/refresh" 
```

```javascript
const url = new URL("http://localhost/api/auth/refresh");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/refresh`


<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->

<!-- START_a47210337df3b4ba0df697c115ba0c1e -->
## api/auth/me
> Example request:

```bash
curl -X POST "http://localhost/api/auth/me" 
```

```javascript
const url = new URL("http://localhost/api/auth/me");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/auth/me`


<!-- END_a47210337df3b4ba0df697c115ba0c1e -->

<!-- START_c84ecb8d4fd02d9a637dac124b62c629 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/books" 
```

```javascript
const url = new URL("http://localhost/api/books");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):


```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/books`


<!-- END_c84ecb8d4fd02d9a637dac124b62c629 -->

<!-- START_33c6d64a451af167032c5c54df96db5c -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/books" 
```

```javascript
const url = new URL("http://localhost/api/books");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/books`


<!-- END_33c6d64a451af167032c5c54df96db5c -->

<!-- START_12c1c577fc002b5da2d75267229f7bb3 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/books/1" 
```

```javascript
const url = new URL("http://localhost/api/books/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):


```json
{
    "message": "Token not provided"
}
```

### HTTP Request
`GET api/books/{book}`


<!-- END_12c1c577fc002b5da2d75267229f7bb3 -->

<!-- START_1509377236aad3ef10e45fbea2aa91aa -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "http://localhost/api/books/1" 
```

```javascript
const url = new URL("http://localhost/api/books/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/books/{book}`

`PATCH api/books/{book}`


<!-- END_1509377236aad3ef10e45fbea2aa91aa -->

<!-- START_d75ecf1315f29c879b459ea9788d1c21 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/books/1" 
```

```javascript
const url = new URL("http://localhost/api/books/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/books/{book}`


<!-- END_d75ecf1315f29c879b459ea9788d1c21 -->

<!-- START_4d21b73474945e18a2da984697261fcf -->
## api/books/{book}/ratings
> Example request:

```bash
curl -X POST "http://localhost/api/books/1/ratings" 
```

```javascript
const url = new URL("http://localhost/api/books/1/ratings");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/books/{book}/ratings`


<!-- END_4d21b73474945e18a2da984697261fcf -->



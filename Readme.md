
To see all results, check out the API page: [https://api.mail.tm/](https://api.mail.tm/)

User needs to login to access JWT token. Registration does not return this information, log in after registration.


After the login process, the user's JWT token and ID are assigned to `mailtm.token` and `mailtm.id`

---


# Domain

## List Domains

```php
$result = (new Mailtm())->getDomains();
```

## Get Domain

```php
$result = (new Mailtm())->getDomains('[domain id]');
```

## Test Challenge
Create a new Laravel application as a multiple role blog system, API only, no need to do frontend. A normal user can CRUD his own posts, a manager can CRUD all posts, and an admin can CRUD all posts and users. 

## How to run
```
docker-compose up -d
```

## Example of API calls
This come with sample user data from migration for testing purpose. Assume the running application url is http://localhost/api

---
### Login to get api_token
```
curl --location --request POST 'localhost/api/login?email=admin@admin.com&password=password'
```
Response:
```
{
    "user": {
        "id": 1,
        "name": "Admin",
        "email": "admin@admin.com",
        "email_verified_at": null,
        "created_at": null,
        "updated_at": null,
        "user_type": "admin",
        "api_token": "testing_token_admin"
    },
    "access_token": "testing_token_admin"
}
```

---
### Users CRUD API
```
# Create New User
curl --location --request POST 'localhost/api/users' \
--header 'Authorization: Bearer testing_token_admin' \
--form 'name="user"' \
--form 'password="password"' \
--form 'email="user@user.com"' \
--form 'user_type="user"'

# View List
curl --location --request GET 'localhost/api/users' \
--header 'Authorization: Bearer testing_token_admin'

# View User
curl --location --request GET 'localhost/api/users/1' \
--header 'Authorization: Bearer testing_token_admin'

# Update User
curl --location --request PUT 'localhost/api/users/1' \
--header 'Authorization: Bearer testing_token_admin' \
--form 'user_type="user"'

# Delete User
curl --location --request DELETE 'localhost/api/users/1' \
--header 'Authorization: Bearer testing_token_admin'

```

---
### Posts CRUD API
```
# Create New Post
curl --location --request POST 'localhost/api/posts' \
--header 'Authorization: Bearer testing_token_admin' \
--form 'title="Post Title"' \
--form 'body="Post Contents"'

# View List
curl --location --request GET 'localhost/api/posts' \
--header 'Authorization: Bearer testing_token_admin'

# View Post
curl --location --request GET 'localhost/api/posts/1' \
--header 'Authorization: Bearer testing_token_admin'

# Update Post
curl --location --request PUT 'localhost/api/posts/1' \
--header 'Authorization: Bearer testing_token_admin' \
--form 'title="Post Title"' \
--form 'body="Post Contents"'

# Delete Post
curl --location --request DELETE 'localhost/api/posts/1' \
--header 'Authorization: Bearer testing_token_admin'

```
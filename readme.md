# Introduction
Code for the complaint portal service in the NITT app.

# Setup 
 1. To get it running, install docker and docker-compose on your host machine.
 2. Copy `.env.example` to `.env.prod`
 3. Run `sh keygen.sh` and paste the base_64 key in APP_KEY in .env.prod.
 4. Create a folder called `logs`, and create the files : nginx-error.log and nginx-access.log
 5. Run `docker-compose up` from inside the project directory. The app will now be available from http://0.0.0.0:8080
 6. To add datatables, run  `docker exec complaints-application php artisan migrate`
 7. Run this command for setting up defaults, `docker exec complaints-application php artisan db:seed`
 
# Complaints

## Get User Complaints

```javascript
    $.ajax({
        url: 'http://spider.nitt.edu/nittcomplaints/api/v1/complaints'
        type: 'GET'
    });

```

> The above command returns JSON structured like this:

```json
{
    "message": "complaints available",
    "data": [
        {
            "id": 5,
            "title": "Magnam porro sint aliquid hic officia iste id.",
            "description": "Autem nulla et vero recusandae et. Iusto est voluptatum et provident molestiae dolor. Voluptatum aut animi ea id.",
            "image_url": "http://www.schultz.com/ut-omnis-vitae-sit-ratione-in-et-ut-debitis.html",
            "status_id": 2,
            "created_at": "2017-10-18 07:55:26",
            "status": {
                "name": "ex",
                "message": "Repellendus."
            }
        },
        {
            "id": 8,
            "title": "Optio possimus fugiat provident et doloribus eum.",
            "description": "Sunt et et officia est. Animi dolores consequuntur nam harum. Delectus consequatur incidunt praesentium sit.",
            "image_url": "http://corkery.biz/",
            "status_id": 1,
            "created_at": "2017-10-15 16:45:53",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            }
        },
        {
            "id": 11,
            "title": "Ab non itaque laboriosam dolorem provident ullam.",
            "description": "Sint quae cupiditate occaecati porro blanditiis harum. Aut voluptatem dolor laudantium nam. Delectus magni magnam et.",
            "image_url": "http://wyman.biz/",
            "status_id": 3,
            "created_at": "2017-10-16 08:45:23",
            "status": {
                "name": "veritatis",
                "message": "Accusantium neque."
            }
        },
        {
            "id": 12,
            "title": "Esse laudantium deserunt vitae sit ut in.",
            "description": "Saepe omnis quia omnis ullam ut. Ad et et et voluptatibus aliquam accusantium molestias minus. Cupiditate quisquam quia et ipsam perferendis. Voluptatem tempora aut voluptas reprehenderit.",
            "image_url": "http://www.bayer.com/id-non-quia-corrupti-fugiat-ipsa.html",
            "status_id": 1,
            "created_at": "2017-10-12 20:47:14",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            }
        },
        {
            "id": 13,
            "title": "Doloribus vero dolore ea dignissimos.",
            "description": "Alias eos exercitationem similique magni. Qui in possimus autem incidunt rem consectetur molestias. Aspernatur nesciunt eius molestiae exercitationem. Dolor deserunt ab a impedit repellendus blanditiis unde. Rerum reprehenderit et consequatur nihil qui rerum nulla.",
            "image_url": "http://russel.org/quam-temporibus-voluptate-molestias-accusamus-consequuntur-nam",
            "status_id": 1,
            "created_at": "2017-10-11 02:49:54",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            }
        },
        {
            "id": 18,
            "title": "Eos nisi accusamus quia ut deleniti a.",
            "description": "Qui eum incidunt officia. Asperiores aut deserunt commodi exercitationem deserunt ab. Aut earum corrupti quaerat minus eveniet accusantium voluptatem.",
            "image_url": "https://pfeffer.com/enim-id-voluptatem-sit-vero.html",
            "status_id": 3,
            "created_at": "2017-10-14 20:37:51",
            "status": {
                "name": "veritatis",
                "message": "Accusantium neque."
            }
        }
    ]
}
```

This endpoint retrieves the currently logged in user's complaints.

### HTTP Request

`GET http://spider.nitt.edu/nittcomplaints/api/v1/complaints`

### Query Parameters

Parameter | Default | Description
--------- | ------- | -----------
start_date | none | complaints with created date with this date as max cap.
end_date | none | complaints with created date with this date as min cap.

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Add User Complaint

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/complaints',
    type: 'POST'
})
```

> The above command returns JSON structured like this:

```json
{
    "message": "complaint sucessfully created"
}
```

This endpoint creates a new complaint for the logged in user.

### HTTP Request

`POST http://spider.nitt.edu/nittcomplaints/api/v1/complaints`

### Request Parameters

Parameter | Description
--------- | -----------
title | title of the complaint
description | complaint description
image_url | in case the complaint has any images attached. please provide the image link, we do not store images on the server

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Update Specific Complaint

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/complaints'
    type: 'PUT'
});
```

> The above command returns JSON structured like this:

```json
{
    "message": "complaint sucessfully edited"
}
```

This endpoint updates a specific complaint.

### HTTP Request

`PUT https://spider.nitt.edu/nittcomplaints/api/v1/complaints`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_id | The ID of the complaint to update
title | The title of the complaint
description | The description of the complaint
image_url | The image url of the complaint

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Delete Specific Complaint

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/complaints'
    type: 'DELETE'
});
```

>  The above command returns JSON structured like this:

```json
{
    "message": "complaint sucessfully deleted"
}
```

This endpoint deletes a specific complaint.

### HTTP Request

`DELETE https://spider.nitt.edu/nittcomplaints/api/v1/complaints`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_id | The ID of the complaint

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

# Comments

## Get a specfic complaint's comments

```javascript
    $.ajax({
        url: 'http://spider.nitt.edu/nittcomplaints/api/v1/comments/6'
        type: 'GET'
    });

```

> The above command returns JSON structured like this:

```json
{
    "message": "comments available",
    "data": [
        {
            "id": 21,
            "complaint_id": 6,
            "user_id": 2,
            "comment": "Et tempore et quibusdam. Quis explicabo odio omnis corrupti laudantium praesentium. Vero aut at omnis est sit. Maxime facilis provident in rerum aut vero totam.",
            "created_at": "2018-01-10 12:44:11",
            "updated_at": "2018-01-10 12:44:11"
        },
        {
            "id": 23,
            "complaint_id": 6,
            "user_id": 2,
            "comment": "Aliquam earum ut voluptatem nostrum nostrum. Earum corporis possimus et nulla maiores. Veritatis at deleniti excepturi rerum aspernatur molestias.",
            "created_at": "2018-01-10 12:44:11",
            "updated_at": "2018-01-10 12:44:11"
        }
    ]
}
```

This endpoint retrieves the comments of the complaint.

### HTTP Request

`GET http://spider.nitt.edu/nittcomplaints/api/v1/comments/{complaint_id}`

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Add a comment

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/comments',
    type: 'POST'
})
```

> The above command returns JSON structured like this:

```json
{
    "message": "comment created successfully"
}
```

This endpoint creates a new comment for the complaint for the logged in user.

### HTTP Request

`POST http://spider.nitt.edu/nittcomplaints/api/v1/comments`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_id | ID of the complaint 
comment | comment text

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Update Specific Comment

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/complaints'
    type: 'PUT'
});
```

> The above command returns JSON structured like this:

```json
{
    "message": "comment updated successfully"
}
```

This endpoint updates a specific comment.

### HTTP Request

`PUT https://spider.nitt.edu/nittcomplaints/api/v1/comments`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_comment_id | The ID of the complaint to update
comment | comment text

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Delete Specific Complaint

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/complaints/9'
    type: 'DELETE'
});
```

>  The above command returns JSON structured like this:

```json
{
    "message": "comment deleted successfully"
}
```

This endpoint deletes a specific comment.

### HTTP Request

`DELETE https://spider.nitt.edu/nittcomplaints/api/v1/comments/{complaint_comment_id}`

###URL Request Parameters

Parameter | Description
--------- | -----------
complaint_id | The ID of the complaint

<aside class="success">
Remember — the user should be logged in to access this route
</aside>


# Admin Routes

## get all complaints

```javascript
    $.ajax({
        url: 'http://spider.nitt.edu/nittcomplaints/v1/admin/complaints?page=1'
        type: 'GET'
    });

```

> The above command returns JSON structured like this:

```json
{
    "message": "complaints available",
    "data": [
        {
            "id": 11,
            "user_id": 4,
            "title": "Ab non itaque laboriosam dolorem provident ullam.",
            "description": "Sint quae cupiditate occaecati porro blanditiis harum. Aut voluptatem dolor laudantium nam. Delectus magni magnam et.",
            "status_id": 3,
            "image_url": "http://wyman.biz/",
            "created_at": "2017-10-16 08:45:23",
            "status": {
                "name": "veritatis",
                "message": "Accusantium neque."
            },
            "user": {
                "username": "I1YZiJap38",
                "name": "Kennedy Braun I",
                "room_no": 6,
                "hostel_id": 4,
                "phone_contact": "9120110439",
                "whatsapp_contact": "0764457552",
                "email": "kylee11@example.net",
                "hostel": "aspernatur"
            }
        },
        {
            "id": 12,
            "user_id": 4,
            "title": "Esse laudantium deserunt vitae sit ut in.",
            "description": "Saepe omnis quia omnis ullam ut. Ad et et et voluptatibus aliquam accusantium molestias minus. Cupiditate quisquam quia et ipsam perferendis. Voluptatem tempora aut voluptas reprehenderit.",
            "status_id": 1,
            "image_url": "http://www.bayer.com/id-non-quia-corrupti-fugiat-ipsa.html",
            "created_at": "2017-10-12 20:47:14",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            },
            "user": {
                "username": "I1YZiJap38",
                "name": "Kennedy Braun I",
                "room_no": 6,
                "hostel_id": 4,
                "phone_contact": "9120110439",
                "whatsapp_contact": "0764457552",
                "email": "kylee11@example.net",
                "hostel": "aspernatur"
            }
        },
        {
            "id": 13,
            "user_id": 4,
            "title": "Doloribus vero dolore ea dignissimos.",
            "description": "Alias eos exercitationem similique magni. Qui in possimus autem incidunt rem consectetur molestias. Aspernatur nesciunt eius molestiae exercitationem. Dolor deserunt ab a impedit repellendus blanditiis unde. Rerum reprehenderit et consequatur nihil qui rerum nulla.",
            "status_id": 1,
            "image_url": "http://russel.org/quam-temporibus-voluptate-molestias-accusamus-consequuntur-nam",
            "created_at": "2017-10-11 02:49:54",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            },
            "user": {
                "username": "I1YZiJap38",
                "name": "Kennedy Braun I",
                "room_no": 6,
                "hostel_id": 4,
                "phone_contact": "9120110439",
                "whatsapp_contact": "0764457552",
                "email": "kylee11@example.net",
                "hostel": "aspernatur"
            }
        },
        {
            "id": 17,
            "user_id": 3,
            "title": "Sed itaque possimus eum.",
            "description": "Qui aliquam reiciendis eaque aperiam et est. Est aliquid porro voluptatem rerum voluptatem minus eos. Praesentium voluptatem possimus rerum dolores quis. Vero deleniti odio reprehenderit consequatur sed a.",
            "status_id": 1,
            "image_url": "http://collins.info/",
            "created_at": "2017-10-19 10:41:27",
            "status": {
                "name": "quo",
                "message": "Rerum totam."
            },
            "user": {
                "username": "MwcYnifu24",
                "name": "Miss Marge Balistreri",
                "room_no": 9,
                "hostel_id": 1,
                "phone_contact": "0366528491",
                "whatsapp_contact": "0167430247",
                "email": "mittie06@example.net",
                "hostel": "autem"
            }
        },
        {
            "id": 18,
            "user_id": 4,
            "title": "Eos nisi accusamus quia ut deleniti a.",
            "description": "Qui eum incidunt officia. Asperiores aut deserunt commodi exercitationem deserunt ab. Aut earum corrupti quaerat minus eveniet accusantium voluptatem.",
            "status_id": 3,
            "image_url": "https://pfeffer.com/enim-id-voluptatem-sit-vero.html",
            "created_at": "2017-10-14 20:37:51",
            "status": {
                "name": "veritatis",
                "message": "Accusantium neque."
            },
            "user": {
                "username": "I1YZiJap38",
                "name": "Kennedy Braun I",
                "room_no": 6,
                "hostel_id": 4,
                "phone_contact": "9120110439",
                "whatsapp_contact": "0764457552",
                "email": "kylee11@example.net",
                "hostel": "aspernatur"
            }
        }
    ]
}
```

This endpoint retrieves the complaints of all the users

### HTTP Request

`GET http://spider.nitt.edu/nittcomplaints/v1/admin/complaints?page={page_id}`

### Request Parameters

Parameter | Description
--------- | -----------
start_date | upper date limit
end_date | lower date limit
hostel | hostel name
status | status name

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## get the available statuses

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/admin/statuses',
    type: 'GET'
})
```

> The above command returns JSON structured like this:

```json
{
    "message": "statuses available",
    "data": [
        {
            "id": 1,
            "name": "quo",
            "message": "Rerum totam."
        },
        {
            "id": 2,
            "name": "ex",
            "message": "Repellendus."
        },
        {
            "id": 3,
            "name": "veritatis",
            "message": "Accusantium neque."
        },
        {
            "id": 4,
            "name": "nobis",
            "message": "Ut quia temporibus."
        }
    ]
}
```

This endpoint returns the available statuses
### HTTP Request

`GET https://spider.nitt.edu/nittcomplaints/api/v1/admin/statuses`

### Request Parameters

Parameter | Description
--------- | -----------
page | page number

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Update status for a comment

```javascript
$.ajax({
    url: '/v1/admin/complaints/status'
    type: 'PUT'
});
```

> The above command returns JSON structured like this:

```json
{
    "message": "status updated successfully"
}
```

This endpoint updates a specific comment.

### HTTP Request

`PUT https://spider.nitt.edu/nittcomplaints/api/v1/admin/complaints/status`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_id | complaint id of the 
status_id | status id

<aside class="success">
Remember — the user should be logged in to access this route
</aside>

## Edit IsPublic Status for Complaint

```javascript
$.ajax({
    url: 'https://spider.nitt.edu/nittcomplaints/api/v1/admin/complaints'
    type: 'PUT'
});
```

> The above command returns JSON structured like this:

```json
{
    "message": "complaint status sucessfully changed"
}
```

This endpoint updates a specific complaint.

### HTTP Request

`PUT https://spider.nitt.edu/nittcomplaints/api/v1/admin/complaints`

### Request Parameters

Parameter | Description
--------- | -----------
complaint_id | The ID of the complaint to update

<aside class="success">
Remember — the admin should be logged in to access this route
</aside>

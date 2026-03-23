# bubble api

speechmeme.com-like API (https://speechmeme.com/)

## endpoint
`post /index.php`

## parameters
| key | type | description |
| :--- | :--- | :--- |
| `image` | file | png, jpg, or gif to process. |

## example (curl)
```bash
curl -X POST -F "image=@file.png" https://p6.skin/bubbleapi/index.php
```

## response
```json
{
  "status": "success",
  "url": "https://p6.skin/bubbleapi/a/u_69c193ebd9c05.gif"
}
```

## setup
1. upload `index.php` and `bubble.png`. thats it
2. requires php 8.0+ and gd extension.

## hosted version
`https://p6.skin/bubbleapi/index.php` / `https://p6.skin/bubbleapi/`

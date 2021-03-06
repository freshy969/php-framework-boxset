![Unbox it now](https://www.vinexs.com/boxset/assets/main/img/logo_small.png)

# Boxset
A set for code written based on MVC Structure. It come with a very simple file structure. Suitable for simple website. Really easy to pick up. If you do not want a complex php framework. Just _CLONE_ it!

## Features
- Redirect URL to different **handler function** in Main Controller.
- Support multiple activity.
- Support modularized project.
- Multiple language source, database and ini is supported.
- Gulp toolkit to watch & compile assets.
- Open source CMS.

## Requirement
- Web server with URL rewrite module **ENABLED**.
- php > 5.0.
- Nodejs. _(if you use gulp to compile assets)_.

## Documentation
https://www.vinexs.com/boxset/documentation

## Security
Read only environment is more secure on web server. This framework support working on read only environment. Try to keep your document root folder read only and set writable path at `$START_UP['application']['main']['storage']` in _startup.php_. Put all writable content to this main.storage.

## Getting start with boxset
1. Fill in the {value} in _startup.php_  or build it from [here](https://www.vinexs.com/boxset/getting_start).
1. Add your code to _main/_

## Getting start with CMS module
CMS module provide CRUD management tool use website admin. It is a replaceable module, do not change any code inside the module package, use extends instead. In this package, _cms/_ folder is an activity extended from cms module. You may add DB controller in _cms/controllers/_ folder to fit your own needed.

#### Setup CMS module
1. Setup _startup.php_ .
1. Import _db.sql_ to database.
1. Set `$SETTING['db_source']` in _cms/settings/setting.php_ to a database name which contain in _startup.php_.
1. Go to your website, for example www.example.com/cms .
1. Login account "admin" width password "admin".
1. Remember to change your admin password.

#### Add DB controller
1. Create class extended from DBHandlerBase.class.php
1. Set public variable $table to match your table format.
1. Add an item to `$SETTING['menu']` in _cms/settings/setting.php_. This item repersent the navigation menu items.

#### Tips
- Set `$SETTING['page_size']` in _cms/settings/setting.php_ can modify the number of row showing in one page.
- You can use custom prefix by changing `$SETTING['table_prefix']` in _cms/settings/setting.php_.

## TODO
Here are some features wanted to add in future.
- [x] Add module CMS.
- [x] Add gulp to compile assets.
- [ ] Add CRUD data-type TIME_PICK.
- [ ] Add CRUD data-type COLOR_PICK.
- [ ] Use transaction in CRUD action.
- [ ] Modify CMS module to support multiple admin role.
- [ ] Add blog module.
- [ ] Add shopping module.

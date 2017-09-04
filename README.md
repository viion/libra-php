# Libra PHP Library

A simple PHP library to read the Final Fantasy XIV Libra SQLite file and output JSON.

> Important Note: This library does not provide the `app_data.sqlite` file, but also will not work without it. You must obtain it through your own legitimate means.

```
$ php cli action=data table=Achievement columns="Key as ID","Name_en as Name" limit=0,1

Array
(
    [0] => Array
        (
            [ID] => 1
            [Name] => To Crush Your Enemies I
        )

)
```

___


## Getting Started

Download the repo to run in the command line for stand alone use.
> Note: If you download the repo, you must have composer install and will have to run `composer install` within the repo to download `PHPUnit` and build Namespaces.

For use inside web applications, use composer:

```php
composer require viion/libra-php
```

Simple usage inside a web application

```php
$api = new Libra\Api();
$tables = $api->getTableList();
```

By default it will look for the sqlite file in the `db` folder, if you are extending this class from your application you can provide the sqlite path+file in the `Api()` constructor, eg:

```php
$api = new Libra\Api('path/to/your/file/app_data.sqlite');
```

## Methods

- `setOption` Set API Options, eg:
  - `('json', false|true)` enable or disable json response
  - View more options in the next section

- `getTableList` Get a list of available tables

- `getTableData` Get data from a table
    - `($table, $columns = "*", $where = false, $limit = false)` Valid options
    
- `dumpAll()` Dump all data into jsons

## Using the CLI Component

You can run the API on the cli very easily, this can be done in the form of:

```bash
php cli <action> <arguments> <options>
```

Arguments and options are both optional params and can be ignored in some uses. Use the list of available commands below for further details.

**Actions**

- `php cli action=tablelist` Print a list of tables
- `php cli action=version` Print sqlite version information
- `php cli action=data` Print data from a table
    - Options:
        - `table=<Table>`
        - `columns=<col>,<col>,<col>`
        - `where="statement"`
        - `limit=<start>,<length>`
- `php cli action=dumpall` Dump all data to jsons, you will need a lot of memory for this (1gb+)
    - Options:
        - `chunks=<size>` Dumping everything can provide large files, this can be broken up to chunks of a size of your choosing, eg: `chunks=2500` to create a new file every 2500 entries in the json
        
**Options**

- `php cli action=<action> json=1`
- `php cli action=<action> json_pretty=1` - Print the json in a pretty format
- `php cli action=<action> dump=1` - Dump the results into the `/dump/*` folder
- `php cli action=<action> output=1` - Enable cli print (default on for cli)

> Note: Dumping files appends on a unix timestamp to avoid overwriting existing json files for the same function.

### Print table data

> Note: `Key` is also known as the `id`, it may be referenced as either or.

> Note: Some tables have a `data` column which contains json, this is automatically decoded into an array and presented as extra layers.

The main command is:

```bash
php cli data table=<table>
```

Example:

```bash
php cli action=data table=Item where="Key=3 OR Key=5" limit=0,5 columns=Key,icon
```

This would print item 3 and 5 and only include the `Key` and the `icon`

```bash
php cli action=data table=Item columns=Key,icon limit=0,1000 dump=1
```

Dump all item `Key` (aka ID) and `icon` to a file in the dump directory.


```bash
php cli action=data table=Achievement limit=0,50 dump=1 output=0
```

Dump all achievement data with a limit of the first 50 entries, don't output to screen.

```bash
php cli action=data table=Achievement columns="Key as ID","Name_en as Name" limit=0,1
```

Print the first achievement with the column `Key` named `ID` and the column `Name_en` as `Name`
